<?php

class BookmarksController extends AppController {
    public $autoLayout = false;

    public function isAuthorized($user = null)
    {
        // 登録済ユーザーの許可範囲
        if (in_array($this->action, array('add', 'delete'))) {
            return true;
        }
        return parent::isAuthorized($user);
    }

    public function add()
    {
        if ($this->request->onlyAllow(['ajax'])) {
            $conditions = [
                'Bookmark.user_id' => $this->request->data('user_id'),
                'Bookmark.knowledge_id' => $this->request->data('knowledge_id')
            ];
            if ($this->Bookmark->find('count', ['conditions' => $conditions]) === 0) {
            // 未ブックマーク
                $this->Bookmark->save($this->request->data());
            }
        }
    }

    public function delete()
    {
        if ($this->request->onlyAllow(['ajax'])) {
            $conditions = [
                'Bookmark.user_id' => $this->request->data('user_id'),
                'Bookmark.knowledge_id' => $this->request->data('knowledge_id')
            ];
            $this->Bookmark->delete($this->Bookmark->field('Bookmark.id', $conditions));
        }
    }
}