<?php
// Session情報の更新（プロフィールの変更があったときなどに使う）
App::uses('Component', 'Controller');

class GetBookmarksComponent extends Component
{
    public function initialize(Controller $controller) {
        $this->controller = $controller;
    }

    // ログインユーザーがbookmarkしてるknowledge_idを取得する
    public function getBookmarks()
    {
        return Hash::extract($this->controller->Bookmark->find('all', [
            'conditions' => ['Bookmark.user_id' => SessionComponent::read('Auth.User.id')],
            'fields' => 'Bookmark.knowledge_id'
        ]), '{n}.Bookmark.knowledge_id');
    }
}