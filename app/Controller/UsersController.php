<?php

App::uses('File', 'Utility');
class UsersController extends AppController {
    public $autoLayout = false;

    public $helpers = array('Html', 'Form');
    public $uses = ['User', 'Department', 'Question', 'Knowledge'];
    public $components = ['UsersList', 'UpdateSession'];
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
            $uploaddir = WWW_ROOT . 'img/icon/';
            
            // // saveの前にvalidationチェック
            $this->User->set($this->request->data);
            if ($this->User->validates()){ // validation error なし
                // // ファイル名が被らないように画像のファイル名を新しくつける
                // メールアドレスから画像の名前をつける（"."は"_"に置換）
                $img_name = str_replace('.', '_', explode('@', $this->request->data['User']['mail_address'])[0]);
                // 拡張子は送られてきた画像のものを使う
                $img_original_name = explode('.', $this->request->data['User']['image']['name']);
                $img_extension = $img_original_name[count($img_original_name) - 1];
                $img_filename = $img_name . '.' . $img_extension;
                $uploadfile = $uploaddir . $img_filename;

                // 画像の保存（move_uploaded_file()でtmp画像を"webroot/img/icon/"下に移動）
                if (move_uploaded_file($this->request->data['User']['image']['tmp_name'], $uploadfile)) {
                    $save_data = [];
                    $save_data['User']['image'] = $img_filename;

                    // 画像を保存
                    $this->User->save($save_data, $validate = false);
                    $this->UpdateSession->updateSession(); //セッション情報を更新する
                    $this->Session->setFlash(
                        'プロフィール画像を更新しました',
                        'default',
                        ['class' => 'alert alert-success']
                    );
                } else {
                    $this->Session->setFlash(
                        'プロフィール画像の保存に失敗しました',
                        'default',
                        ['class' => 'alert alert-danger']
                    );
                }    
            } else { // validation error が見つかった
                $this->Session->setFlash(
                    'プロフィール画像を更新できませんでした',
                    'default',
                    ['class' => 'alert alert-danger']
                );
            }

            // $uploaddir = WWW_ROOT . 'img/icon/';
            // $uploadfile = $uploaddir . basename($this->request->data['User']['image']['name']);
            // // tmp画像をwebroot/img/icon/に移動
            // if (move_uploaded_file($this->request->data['User']['image']['tmp_name'], $uploadfile)) {
            //     $save_data = $this->request->data;
            //     $save_data['User']['image'] = $this->request->data['User']['image']['name'];     
            //     if ($this->User->save($save_data)) {
            //         $this->Session->setFlash(
            //             '登録に成功しました',
            //             'default',
            //             ['class' => 'alert alert-success']
            //         );
            //         $this->redirect(array('action' => 'login'));
            //     } else {
            //         $this->Session->setFlash(
            //             '登録に失敗しました',
            //             'default',
            //             ['class' => 'alert alert-danger']
            //         );
            //     }
            // } else {
            //     $this->Session->setFlash(
            //         '画像の保存に失敗しました',
            //         'default',
            //         ['class' => 'alert alert-danger']
            //     );
            // }
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
            $uploaddir = WWW_ROOT . 'img/icon/';

            // // ファイル名が被らないように画像のファイル名を新しくつける
            // メールアドレスから画像の名前をつける（"."は"_"に置換）
            $img_name = str_replace('.', '_', explode('@', $this->User->field('mail_address'))[0]);
            // 拡張子は送られてきた画像のものを使う
            $img_original_name = explode('.', $this->request->data['User']['image']['name']);
            $img_extension = $img_original_name[count($img_original_name) - 1];
            $img_filename = $img_name . '.' . $img_extension;
            $uploadfile = $uploaddir . $img_filename;
            
            // // saveの前にvalidationチェック
            $this->User->set($this->request->data);
            if ($this->User->validates()){ // validation error なし
                // 画像の保存（move_uploaded_file()でtmp画像を"webroot/img/icon/"下に移動）
                if (move_uploaded_file($this->request->data['User']['image']['tmp_name'], $uploadfile)) {
                    $save_data = [];
                    $save_data['User']['image'] = $img_filename;

                    // 画像を保存
                    $this->User->save($save_data, $validate = false);
                    $this->UpdateSession->updateSession(); //セッション情報を更新する
                    $this->Session->setFlash(
                        'プロフィール画像を更新しました',
                        'default',
                        ['class' => 'alert alert-success']
                    );
                } else {
                    $this->Session->setFlash(
                        'プロフィール画像の保存に失敗しました',
                        'default',
                        ['class' => 'alert alert-danger']
                    );
                }    
            } else { // validation error が見つかった
                $this->Session->setFlash(
                    'プロフィール画像を更新できませんでした: ' . $this->User->validationErrors['image'][0],
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

    public function delete()
    {
        debug($this->request->data);
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        } elseif ($this->request->is('post')) {
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