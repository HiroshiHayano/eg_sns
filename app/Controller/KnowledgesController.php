<?php

class KnowledgesController extends AppController {
    public $autoLayout = false;

    public $helpers = array('Html', 'Form', 'Display');
    public $uses = array('Knowledge', 'Comment', 'User');
    // コメントテーブルを新しく追加したほうが良い

    public function isAuthorized($user = null)
    {
        // 登録済ユーザーの許可範囲
        if (in_array($this->action, array('view', 'add'))) {
            return true;
        }
        return parent::isAuthorized($user);
    }

    public function view($id = NULL)
    {
        $knowledge = $this->Knowledge->find('first', array(
            'conditions' => array(
                'id' => $id,
            )
        ));
        $this->set('knowledge', $knowledge);

        // テーブルを新しく追加すべき
        // $comments = $this->Comment->find('all', array(
        //     'conditions' => array(
        //         'answer_id' => $knowledge['Knowledge']['id'],
        //     )
        // ));
        $comments = array();
        $this->set('comments', $comments);

        // ユーザーの顔画像パス一覧取得
        $this->set('users_image', $this->User->find(
            'list', array(
                'fields' => array(
                    'image'
                )
            )
        ));
        // ユーザーの名前一覧取得
        $this->set('users_name', $this->User->find(
            'list', array(
                'fields' => array(
                    'name'
                )
            )
        ));
    }

    public function add()
    {   
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        } elseif ($this->request->is('post')) {
            if ($this->Knowledge->save($this->request->data)) {
                $this->redirect($this->referer());
                $this->Session->setFlash(
                    '質問投稿しました',
                    'default'
                );
            } else {
                $this->Session->setFlash(
                    '質問投稿できませんでした',
                    'default'
                );
            } 
        }
    }
}