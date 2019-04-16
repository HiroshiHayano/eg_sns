<?php

class AnswersController extends AppController {
    public $helpers = array('Html', 'Form');
    public $uses = array('Answer');

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
            if ($this->Answer->save($this->request->data)) {
                $this->redirect($this->referer());
                $this->Session->setFlash(
                    'コメントしました',
                    'default'
                );
            } else {
                $this->Session->setFlash(
                    'コメントできませんでした',
                    'default'
                );
            } 
        }
    }
}