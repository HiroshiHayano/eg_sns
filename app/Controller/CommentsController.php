<?php

class CommentsController extends AppController {
    public $helpers = array('Html', 'Form');
    public $uses = array('Comment');

    public function isAuthorized($user = null)
    {
        // 登録済ユーザーの許可範囲
        if (in_array($this->action, array('add'))) {
            return true;
        }

        return parent::isAuthorized($user);
    }

    public function add()
    {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        } elseif ($this->request->is('post')) {
            if ($this->Comment->save($this->request->data)) {
                $this->redirect($this->referer());
                $this->Flash->set(
                    'コメントしました',
                    array('element' => 'success')
                );
            } else {
                $this->Flash->set(
                    'コメントできませんでした',
                    array('element' => 'error')
                );
            } 
        }
    }
}