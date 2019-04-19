<?php

class UsersController extends AppController {
    public $autoLayout = false;

    public $helpers = array('Html', 'Form');
    public $uses = array('User', 'Department', 'Question', 'Answer', 'Comment');

    public function beforefilter() {
        $this->Auth->allow('login', 'add');
    }

    public function isAuthorized($user = null)
    {
        // 退会済みユーザーのviewページはアクセス不可
        if (!empty($this->params['pass']) & in_array($this->action, array('view'))) {
            $id = $this->params['pass'][0];
            $view_user = $this->User->find('first', array(
                'conditions' => array(
                    'id' => $id,
                ),
            ));
            if ($view_user['User']['is_deleted']) {
                $this->Session->setFlash(
                    '退会済みユーザーです',
                    'default'
                );        
                return false;
            }
        }
        
        // 登録済ユーザーはindex, viewページへアクセス許可
        if (in_array($this->action, array('index', 'view', 'logout'))) {
            return true;
        }
    
        // 自分自身のプロフィール編集、アカウント削除を許可
        if (in_array($this->action, array(
            'edit', 
            'edit_image', 
            'edit_password', 
            'delete',
            ))) {
            $page_id = (int)$this->request->params['pass'][0];
            // 自身のページか判別
            if ($this->User->isOwnedBy($page_id, (int)$user['id'])) {
                return true;
            }
        }
    
        return parent::isAuthorized($user);
    }

    public function index()
    {
        $this->set('users', $this->User->find('all', array(
            'conditions' => array(
                'is_deleted' => false,
            )
        )));
        $this->set('title_for_layout', '社員');
    }

    public function view($id = NULL)
    {
        $this->User->id = $id;
        $this->set('user', $this->User->read());
        $this->Department->id = $this->User->field('department_id');
        $this->set('department', $this->Department->field('name'));
        $question = $this->Question->find('first', array( // 現在はとりあえず一件だけ表示するためにfirstにしている
            'conditions' => array(
                'user_id' => $id,
                'is_resolved' => 0,
            )
        ));
        $this->set('question', $question);

        if (!empty($question)) {
            $this->Question->id = $question['Question']['id'];
            $this->request->data = $this->Question->read();

            // ユーザーの顔画像パス一覧取得
            $this->set('users_image', $this->User->find(
                'list', array(
                    'fields' => array(
                        'image'
                    )
                )
            ));
            // ユーザーの名前一覧取得
            $this->set('users_name', $this->User->find(
                'list', array(
                    'fields' => array(
                        'name'
                    )
                )
            ));

            $answers = $this->Answer->find('all', array(
                'conditions' => array(
                    'question_id' => $question['Question']['id'],
                )
            ));
            $this->set('answers', $answers);
    
            $answers_id = array();
            foreach ($answers as $answer) {
                $answers_id[] = $answer['Answer']['id'];
            }
            $comments = array();
            foreach ($answers_id as $answer_id) {
                $comments_set = array();
                $comments_set += $this->Comment->find('all', array(
                    'conditions' => array(
                        'answer_id' => $answer_id,
                    )
                ));
                $comments += array($answer_id => $comments_set);
            }
            $this->set('comments', $comments);
        } else {
            $this->set('answers', array());
            $this->set('comments', array());
            $this->set('users_name', array());
            $this->set('users_image', array());
        }
    }

    public function login()
    {
        // すでにログインしている場合
        if ($this->Auth->loggedIn()) {
            $this->redirect($this->Auth->redirectUrl());
        }
        // 未ログイン
        if ($this->request->is('post')) {
            if (!empty($this->request->data)) {
                //ログイン成功
                if ($this->Auth->login()) { 
                    if ($this->Session->read('Auth.User.is_deleted') === true) {
                        $this->Session->destroy();
                        $this->redirect($this->Auth->logout());
                        $this->Session->setFlash(
                            '退会済みユーザーです',
                            'default'
                        );
                    } else {
                        $this->redirect($this->Auth->redirectUrl());
                    }
                // ログイン失敗
                } else { 
                    $this->Session->setFlash(
                        'メールアドレスまたはパスワードが違います',
                        'default'
                    );
                }
            }
        }
    }
    
    public function logout()
    {
        $this->Session->destroy();
        $this->redirect($this->Auth->logout());
    }

    public function add()
    {
        $this->set('departments', $this->Department->find('list', array('fields' => 'name')));

        if ($this->request->is('post')) {
            // $image_name = microtime(true) * 10000;
            $uploaddir = WWW_ROOT . 'img/icon/';
            $uploadfile = $uploaddir . basename($this->request->data['User']['image']['name']);
            // tmp画像をwebroot/img/icon/に移動
            if (move_uploaded_file($this->request->data['User']['image']['tmp_name'], $uploadfile)) {
                $save_data = $this->request->data;
                $save_data['User']['image'] = $this->request->data['User']['image']['name'];     
                if ($this->User->save($save_data)) {
                    $this->Session->setFlash(
                        '登録に成功しました',
                        'default'
                    );
                    $this->redirect(array('action' => 'login'));
                } else {
                    $this->Session->setFlash(
                        '登録に失敗しました',
                        'default'
                    );
                }
            } else {
                $this->Session->setFlash(
                    '画像の保存に失敗しました',
                    'default'
                );
            }
        }
    }

    public function edit($id = NULL)
    {   
        $this->set('departments', $this->Department->find('list', array('fields' => 'name')));
        $this->User->id = $id;

        if ($this->request->is('get')) {
            $this->request->data = $this->User->read();
        } else {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(
                    'プロフィールを更新しました',
                    'default'
                );
                $user = $this->User->find('first', array(
                    'conditions' => array(
                        'id' => $this->Auth->user('id')
                    ), 
                    'recursive' => -1
                ));
                unset($user['User']['password']); // パスワードは除く
                $this->Session->write('Auth', $user); // セッション情報を更新する
            } else {
                $this->Session->setFlash(
                    'プロフィールを更新できませんでした',
                    'default'
                );
            }    
        }
    }

    public function edit_image($id = NULL)
    {
        $this->User->id = $id;
        if ($this->request->is('post')) {
            $uploaddir = WWW_ROOT . 'img/icon/';
            $uploadfile = $uploaddir . basename($this->request->data['User']['image']['name']);
            // tmp画像をwebroot/img/icon/に移動
            if (move_uploaded_file($this->request->data['User']['image']['tmp_name'], $uploadfile)) {
                $save_data = $this->request->data;
                $save_data['User']['image'] = $this->request->data['User']['image']['name'];
                if ($this->User->save($save_data, $validate = true)) {
                    $user = $this->User->find('first', array(
                        'conditions' => array(
                            'id' => $this->Auth->user('id')
                        ), 
                        'recursive' => -1
                    ));
                    unset($user['User']['password']); // パスワードは除く
                    $this->Session->write('Auth', $user); // セッション情報を更新する
                    $this->Session->setFlash(
                        'プロフィール画像を更新しました',
                        'default'
                    );
                } else {
                    $this->Session->setFlash(
                        'プロフィール画像を更新できませんでした',
                        'default'
                    );
                }
            } else {
                $this->Session->setFlash(
                    'プロフィール画像を保存に失敗しました',
                    'default'
                );
            }
        }
    }

    public function edit_password($id = NULL)
    {   
        if ($this->request->is('post')) {
            $this->User->id = $id;
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(
                    'パスワードを更新しました',
                    'default'
                );
            } else {
                $this->Session->setFlash(
                    'パスワードを更新できませんでした',
                    'default'
                );
            }
        }
    }

    public function delete($id)
    {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        } else {
            $this->User->id = $id;
            if ($this->User->save($this->request->data)){
                // 退会済みユーザーの質問は解決済みにする
                $question = $this->Question->find('first', ['conditions' => [
                    'user_id' => $id,
                    'is_resolved' => false,
                ]]);
                $question['Question']['is_resolved'] = true;
                $this->Question->id = $id;
                $this->Question->save($question);
                // セッションをdestroy
                $this->Session->destroy();
                $this->Session->setFlash(
                    '削除しました！',
                    'default'
                );
                $this->redirect($this->Auth->logout());    
            }
        }
    }

    public function login_game()
    {
        
    }
}