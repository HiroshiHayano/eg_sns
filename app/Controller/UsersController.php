<?php

class UsersController extends AppController {
    public $autoLayout = false;

    public $helpers = array('Html', 'Form');
    // public $uses = array('User', 'Department', 'Question', 'Answer', 'Comment');
    public $uses = ['User', 'Department', 'Question', 'Knowledge'];
    public $components = ['UsersList'];
    public $paginate = [
        'limit' => 40,
        'order' => ['phonetic' => 'asc'],
        'conditions' => [
            'is_deleted' => false,
            'admin' => false,
            'OR' => []
        ]
    ];


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
                    'default',
                    ['class' => 'alert alert-warning']
                );        
                return false;
            }
        }
        
        // 登録済ユーザーはindex, viewページへアクセス許可
        if (in_array($this->action, array('index', 'view', 'logout', 'questions_view', 'knowledges_view'))) {
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
        if (!empty($this->request->query)) {
            $conditions = [];
            $conditions['OR']['name LIKE'] = '%' . $this->request->query['query'] . '%';
            $conditions['OR']['phonetic LIKE'] = '%' . $this->request->query['query'] . '%';
            $this->Session->write('Conditions', $conditions);
            $this->set('query', $this->request->query['query']);
        } else {
            $this->Session->write('Conditions', []);
            $this->set('query', '');
        }
        $this->set('users', $this->paginate('User', $this->Session->read('Conditions')));
    }

    public function view($id = NULL)
    {
        $this->User->id = $id;
        $this->set('user', $this->User->read());
        $this->Department->id = $this->User->field('department_id');
        $this->set('department', $this->Department->field('name'));

        // プロプページへ引用する投稿の上限
        $number_of_display_posts = 5;
        $questions = $this->Question->find('all', [
            'order' => ['id' => 'desc'],
            'conditions' => ['user_id' => $id],
            'limit' => $number_of_display_posts,
        ]);
        $this->set('questions', $questions);
        $this->set('number_of_questions', $this->Question->find('count', [
            'conditions' => ['user_id' => $id],
        ]));

        $knowledges = $this->Knowledge->find('all', array(
            'order' => ['id' => 'desc'],
            'conditions' => array('user_id' => $id),
            'limit' => $number_of_display_posts,
        ));
        $this->set('knowledges', $knowledges);
        $this->set('number_of_knowledges', $this->Knowledge->find('count', [
            'conditions' => ['user_id' => $id],
        ]));
    }

    // public function questions_view($id = NULL)
    // {
    //     $this->User->id = $id;
    //     $this->set('user', $this->User->read());

    //     $questions = $this->Question->find('all', [
    //         'order' => ['id' => 'desc'],
    //         'conditions' => ['user_id' => $id],
    //     ]);
    //     $this->set('questions', $questions);
    // }

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
                            'default',
                            ['class' => 'alert alert-warning']
                        );
                    } else {
                        $this->redirect($this->Auth->redirectUrl());
                    }
                // ログイン失敗
                } else { 
                    $this->Session->setFlash(
                        'メールアドレスまたはパスワードが違います',
                        'default',
                        ['class' => 'alert alert-warning']
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
                        'default',
                        ['class' => 'alert alert-success']
                    );
                    $this->redirect(array('action' => 'login'));
                } else {
                    $this->Session->setFlash(
                        '登録に失敗しました',
                        'default',
                        ['class' => 'alert alert-danger']
                    );
                }
            } else {
                $this->Session->setFlash(
                    '画像の保存に失敗しました',
                    'default',
                    ['class' => 'alert alert-danger']
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
                    'default',
                    ['class' => 'alert alert-success']
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
                    'default',
                    ['class' => 'alert alert-danger']
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
                        'default',
                        ['class' => 'alert alert-success']
                    );
                } else {
                    $this->Session->setFlash(
                        'プロフィール画像を更新できませんでした',
                        'default',
                        ['class' => 'alert alert-danger']
                    );
                }
            } else {
                $this->Session->setFlash(
                    'プロフィール画像を保存に失敗しました',
                    'default',
                    ['class' => 'alert alert-danger']
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
                    'default',
                    ['class' => 'alert alert-success']
                );
            } else {
                $this->Session->setFlash(
                    'パスワードを更新できませんでした',
                    'default',
                    ['class' => 'alert alert-danger']
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
                    'default',
                    ['class' => 'alert alert-success']
                );
                $this->redirect($this->Auth->logout());    
            }
        }
    }

    public function login_game()
    {
        // if (/*不正解 or get*/) {
        //     // 出題
        //     /* $?? = */ $this->User->find('first', [
        //         'conditions' => [
        //             'is_dereted' => false,
        //             'admin' => false,
        //         ],
        //         'order' => 'rand()'
        //     ]);    
        // } else { //正解
        //     // ログインできる

        // }
    }
}