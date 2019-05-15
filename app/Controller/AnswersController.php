<?php

class AnswersController extends AppController {
    public $helpers = array('Html', 'Form');
    public $uses = array('Answer');
    public $components = ['UsersList'];

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
        if ($this->request->onlyAllow(['post'])) {
            if ($this->Answer->save($this->request->data)) {
                $this->Session->setFlash(
                    '回答しました',
                    'default',
                    ['class' => 'alert alert-success']
                );
                $this->redirect($this->referer());
            } else {
                $this->Session->setFlash(
                    '回答できませんでした',
                    'default',
                    ['class' => 'alert alert-danger']
                );
            } 
        }
    }
}