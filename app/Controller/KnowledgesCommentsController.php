<?php

class KnowledgesCommentsController extends AppController {
    public $uses = array('KnowledgesComment');

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
            if ($this->KnowledgesComment->save($this->request->data)) {
                $this->Session->setFlash(
                    '投稿しました',
                    'default',
                    ['class' => 'alert alert-success']
                );
                $this->redirect($this->referer());
            } else {
                $this->Session->setFlash(
                    '投稿できませんでした',
                    'default',
                    ['class' => 'alert alert-danger']
                );
            } 
        }
    }
}