<?php

class PostsController extends AppController {
    public $helpers = array('Html', 'Form');
    public $uses = array('Posts');

    public function isAuthorized($post = null) {
        // 登録済ユーザーはindex, viewページへアクセス許可
        if (in_array($this->action, array('index', 'view', 'logout'))) {
            return true;
        }
    
        // 自分自身のプロフィール編集、アカウント削除を許可
        // if (in_array($this->action, array(
        //     'edit', 
        //     'edit_image', 
        //     'edit_password', 
        //     'delete',
        //     ))) {
        //     $page_id = (int)$this->request->params['pass'][0];
        //     // 自身のページか判別
        //     if ($this->User->isOwnedBy($page_id, (int)$user['id'])) {
        //         return true;
        //     }
        // }
    
        return parent::isAuthorized($user);
    }

    public function index() {
        $this->set('login_user', $this->Session->read('Auth.User'));

        $this->set('posts', $this->Posts->find('all'));
    }
}