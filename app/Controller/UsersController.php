<?php

App::uses('File', 'Utility');
class UsersController extends AppController {
    public $autoLayout = false;

    public $helpers = ['Html', 'Form', 'UploadPack.Upload'];
    public $uses = ['User', 'Department', 'Question', 'Knowledge', 'Answer', 'Bookmark'];
    public $components = ['UsersList', 'UpdateSession', 'GetBookmarks'];
    public $paginate = [
        'limit' => 20,
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
            'delete_image',
            'delete',
            ))) {
            $page_id = (int)$this->request->params['pass'][0];
            // 自身のページか判別
            if ($this->User->isOwnedBy($page_id, (int)$user['id'])) { //sessionを見るべきでは？
                return true;
            }
        }
    
        return parent::isAuthorized($user);
    }

    public function index()
    {
        $this->set('departments', $this->Department->find('list', array('fields' => 'name')));
        $conditions = [];
        if (!empty($this->request->query['query'])) {
            $conditions['OR']['name LIKE'] = '%' . $this->request->query['query'] . '%';
            $conditions['OR']['phonetic LIKE'] = '%' . $this->request->query['query'] . '%';
            $this->set('query', $this->request->query['query']);
        } else {
            $this->set('query', '');
        }

        if (!empty($this->request->query['department_id'])) {
            $conditions['and']['department_id'] = $this->request->query['department_id'];
            $this->set('department_id', $this->request->query['department_id']);
        } else {
            $this->set('department_id', '');
        }
        $this->Session->write('Conditions', $conditions);
        $this->set('users', $this->paginate('User', $this->Session->read('Conditions')));
        $conditions['is_deleted'] = false;
        $conditions['admin'] = false;
        $this->set('number_of_users', $this->User->find('count', [
            'conditions' => $conditions,
        ]));
    }

    public function view($id = NULL)
    {
        $number_of_display_posts = 3;
        $this->set('user', $this->User->find('first', [
            'conditions' => [
                'User.id' => $id
            ],
        ]));
        $this->Department->id = $this->User->field('department_id', ['User.id' => $id]);
        $this->set('department', $this->Department->field('name'));

        $questions = $this->Question->find('all', [
            'order' => 'Question.id DESC',
            'limit' => $number_of_display_posts,
            'conditions' => ['Question.user_id' => $id],
        ]);
        $this->set(compact('questions'));

        $knowledges = $this->Knowledge->find('all', [
            'order' => 'Knowledge.id DESC',
            'limit' => $number_of_display_posts,
            'conditions' => ['Knowledge.user_id' => $id],
        ]);
        $this->set(compact('knowledges'));

        $answers = $this->Answer->find('all', [
            'order' => 'Answer.id DESC',
            'limit' => $number_of_display_posts,
            'conditions' => ['Answer.user_id' => $id],
        ]);
        $this->set(compact('answers'));

        $bookmarked_knowledges = $this->Bookmark->find('all', [
            'order' => 'Bookmark.id DESC',
            'limit' => $number_of_display_posts,
            'conditions' => ['Bookmark.user_id' => $id],
        ]);
        $this->set(compact('bookmarked_knowledges'));

        $bookmarks = $this->GetBookmarks->getBookmarks(); //bookmarkしてるknowledge_idを取得
        $this->set(compact('bookmarks'));
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
            if ($this->User->save($this->request->data)) {
                $this->UpdateSession->updateSession(); //セッション情報を更新する
                $this->Session->setFlash(
                    'アカウントを新規登録しました',
                    'default',
                    ['class' => 'alert alert-success']
                );
                if ($this->Auth->login()) { 
                    $this->Session->setFlash(
                        'アカウントの新規登録ができました！プロフィール画像を登録しましょう！',
                        'default',
                        ['class' => 'alert alert-info']
                    );    
                    $this->redirect([
                        'controller' => 'users',
                        'action' => 'edit_image',
                        $this->Session->read('Auth.User.id')
                    ]);
                } else {
                    $this->redirect(array(
                        'controller' => 'users', 
                        'action' => 'login'
                    ));    
                }
            } else {
                $this->Session->setFlash(
                    'アカウントの新規登録に失敗しました',
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
                $this->UpdateSession->updateSession(); //セッション情報を更新する
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
            if ($this->User->save($this->request->data)) {
                $this->UpdateSession->updateSession(); //セッション情報を更新する
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
        }
    }

    public function delete_image($id = NULL)
    {
        $this->User->id = $id;
        $data = [
            'User' => [
                'image' => NULL
            ]
        ];
        if ($this->request->onlyAllow(['post'])) {
            if ($this->User->save($data, $validate = False)) {
                $this->UpdateSession->updateSession(); //セッション情報を更新する
                $this->Session->setFlash(
                    'プロフィール画像を削除しました',
                    'default',
                    ['class' => 'alert alert-success']
                );
                $this->redirect($this->referer());
            } else {
                echo 'fail';
                $this->Session->setFlash(
                    'プロフィール画像を削除できませんでした',
                    'default',
                    ['class' => 'alert alert-danger']
                );
                $this->redirect($this->referer());
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

    public function delete()
    {
        // debug($this->request->data);
        if ($this->request->onlyAllow(['post'])) {
            $this->User->id = $this->request->data['User']['id'];
            if ($this->User->save($this->request->data)){
                // 退会済みユーザーの質問は解決済みにする
                $questions = $this->Question->find('all', ['conditions' => [
                    'user_id' => $this->request->data['User']['id'],
                    'is_resolved' => false,
                ]]);
                foreach ($questions as $question) {
                    $question['Question']['is_resolved'] = true;
                    $this->Question->id = $question['Question']['id'];
                    $this->Question->save($question);
                }

                // プロフィール画像を削除
                $profile_image = new File(WWW_ROOT . 'img/icon/' . $this->User->field('image'));
                $profile_image->delete();
                
                // プロフィール画像を削除したとき用のものに置き換える
                // 名前の後ろに"（退会済み）"を付け足す
                $this->User->save(['User' => [
                    // 'id' => $this->User->field('id'),
                    'image' => 'mark_question.png',
                    'name' => $this->User->field('name') . '(退会済み)',
                ]], $validate = false);

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