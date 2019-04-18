<?php

class KnowledgesController extends AppController {
    public $autoLayout = false;

    public $helpers = array('Html', 'Form', 'Display', 'Text');
    public $uses = array('Knowledge', 'KnowledgesComment', 'User');

    public function isAuthorized($user = null)
    {
        // 登録済ユーザーの許可範囲
        if (in_array($this->action, array('view', 'add', 'edit', 'delete'))) {
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
        $this->Knowledge->id = $id;
        $this->request->data = $this->Knowledge->read();

        $comments = $this->KnowledgesComment->find('all', array(
            'conditions' => array(
                'knowledge_id' => $id,
            )
        ));
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
                $this->Session->setFlash(
                    '投稿しました',
                    'default'
                );
                $this->redirect($this->referer());
            } else {
                $this->Session->setFlash(
                    '投稿できませんでした',
                    'default'
                );
            } 
        }
    }

    public function edit()
    {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        } elseif ($this->request->is('post')) {
            if ($this->Knowledge->save($this->request->data)) {
                $this->Session->setFlash(
                    '更新しました',
                    'default'
                );
                $this->redirect($this->referer());
            } else {
                $this->Session->setFlash(
                    '更新できませんでした',
                    'default'
                );
            }
        }
    }

    public function delete($id)
    {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }
        if ($this->Knowledge->delete($id)) {
            $this->Session->setFlash(
                '削除しました！',
                'default'
            );
            $this->redirect(array(
                'controller' => 'questions',
                'action' => 'index'
            ));
        }
    }
}