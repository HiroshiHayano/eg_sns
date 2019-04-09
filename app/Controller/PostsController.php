<?php

class PostsController extends AppController {
    public $helpers = array('Html', 'Form');
    public $uses = array('Post', 'User');

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

        $this->set('posts', $this->Post->find('all', array(
            'order' => array('created' => 'desc'),
            'conditions' => array(
                'send_to' => NULL,
                'is_resolved' => 0,
            )
        )));
        $this->set('users_image', $this->User->find(
            'list',array(
                'fields' => array(
                    'id',
                    'image'
                )
            )
        ));
        $this->set('users_name', $this->User->find(
            'list',array(
                'fields' => array(
                    'id',
                    'name'
                )
            )
        ));
    }
}