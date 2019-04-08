<?php

class UsersController extends AppController {
    public $helpers = array('Html', 'Form');
    public $uses = array('User', 'Department', 'Post');

    public function isAuthorized($user = null) {
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

    public function index() {
        $this->set('login_user', $this->Session->read('Auth.User'));

        $this->set('users', $this->User->find('all'));
        $this->set('title_for_layout', '社員');
    }

    public function view($id = NULL) {
        $this->set('login_user', $this->Session->read('Auth.User'));

        $this->User->id = $id;
        $this->set('user', $this->User->read());
        $this->Department->id = $this->User->field('department_id');
        $this->set('department', $this->Department->field('name'));
        $problem = $this->Post->find('first', array(
            'conditions' => array(
                'user_id' => $id,
                'is_problem' => true,
                'is_resolved' => false,

            ),
        ));
        $this->set('problem', $problem);
        $resolerved_problems = $this->Post->find('all', array(
            'conditions' => array(
                'user_id' => $id,
                'is_problem' => true,
                'is_resolved' => true,

            ),
        ));
        $this->set('resolerved_problems', $resolerved_problems);
    }

    public function login() {
        // すでにログインしている場合
        if ($this->Auth->loggedIn()) {
            $this->redirect($this->Auth->redirectUrl());
        }
        // 未ログイン
        if ($this->request->is('post')) {
            if (!empty($this->request->data)) {
                //ログイン成功
                if ($this->Auth->login()) { 
                    $this->redirect($this->Auth->redirectUrl());
                // ログイン失敗
                } else { 
                    $this->Flash->set(
                        'メールアドレスまたはパスワードが違います',
                        array('element' => 'error')
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
                    $this->redirect(array('action' => 'login'));
                    $this->Flash->set(
                        '登録に成功しました',
                        array('element' => 'success')
                    );
                } else {
                    $this->Flash->set(
                        '登録に失敗しました',
                        array('element' => 'error')
                    );
                }
            } else {
                $this->Flash->set(
                    '画像の保存に失敗しました',
                    array('element' => 'error')
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
                $user = $this->User->find('first', array(
                    'conditions' => array(
                        'id' => $this->Auth->user('id')
                    ), 
                    'recursive' => -1
                ));
                unset($user['User']['password']); // パスワードは除く
                $this->Session->write('Auth', $user); // セッション情報を更新する
                $this->Flash->set(
                    'プロフィールを更新しました',
                    array('element' => 'success')
                );
            } else {
                $this->Flash->set(
                    'プロフィールを更新できませんでした',
                    array('element' => 'error')
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
                    $this->Flash->set(
                        'プロフィール画像を更新しました',
                        array('element' => 'success')
                    );
                } else {
                    $this->Flash->set(
                        'プロフィール画像を更新できませんでした',
                        array('element' => 'error')
                    );
                }
            } else {
                $this->Flash->set(
                    'プロフィール画像を保存に失敗しました',
                    array('element' => 'error')
                );
            }
        }
    }

    public function edit_password($id = NULL)
    {   
        if ($this->request->is('post')) {
            $this->User->id = $id;
            if ($this->User->save($this->request->data)) {
                $this->Flash->set(
                    'パスワードを更新しました',
                    array('element' => 'success')
                );
            } else {
                $this->Flash->set(
                    'パスワードを更新できませんでした',
                    array('element' => 'error')
                );
            }
        }
    }

    public function delete($id)
    {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }
        if ($this->User->delete($id)) {
            $this->Session->destroy();
            $this->redirect($this->Auth->logout());
            $this->Flash->set(
                '削除しました！',
                array('element' => 'success')
            );
        }
    }
}