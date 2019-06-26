<?php

class KnowledgesTagController extends AppController {
    public $uses = ['KnowledgesTag'];
    public function isAuthorized($user = null)
    {
        // 登録済ユーザーの許可範囲
        if (in_array($this->action, array(
            'delete',
            'index', 
            ))) {
            return true;
        }
        return parent::isAuthorized($user);
    }

    public function delete()
    {
        if ($this->request->onlyAllow(['ajax'])) {
            $this->KnowledgesTag->delete($this->request->data('knowledges_tags_id'));
        }
    }
}