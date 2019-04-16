<?php

class QuestionsController extends AppController {
    public $autoLayout = false;

    public $helpers = array('Html', 'Form', 'Display');
    public $uses = array('Question', 'Knowledge');

    public function isAuthorized($user = null)
    {
        // 登録済ユーザーの許可範囲
        if (in_array($this->action, array('index', 'add', 'resolve', 'edit', 'delete'))) {
            return true;
        }
        return parent::isAuthorized($user);
    }

    public function index()
    {
        // 未解決
        $this->set('not_resolved_questions', $this->Question->find('all', array(
            'conditions' => array('is_resolved' => '0'),
            'order' => array('id' => 'desc'),
        )));
        // 解決済み
        $this->set('resolved_questions', $this->Question->find('all', array(
            'conditions' => array('is_resolved' => '1'),
            'order' => array('id' => 'desc'),
        )));
        // 共有知識
        $this->set('knowledges', $this->Knowledge->find('all'), array(
            'order' => array('id' => 'desc'),
        ));
        $this->set('title_len', 20);
        $this->set('content_len', 40);
    }

    public function resolve()
    {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        } elseif ($this->request->is('post')) {
            if ($this->Question->save($this->request->data)) {
                $this->redirect($this->referer());
                $this->Session->setFlash(
                    '質問解決しました',
                    'default'
                );
            } else {
                $this->Session->setFlash(
                    'エラーが起きました',
                    'default'
                );
            }
        }
    }

    public function add()
    {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        } elseif ($this->request->is('post')) {
            if ($this->Question->save($this->request->data)) {
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

    public function edit()
    {
        // debug($this->request);
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        } elseif ($this->request->is('post')) {
            if ($this->Question->save($this->request->data)) {
                $this->redirect($this->referer());
                $this->Session->setFlash(
                    '質問を更新しました',
                    'default'
                );
            } else {
                $this->Session->setFlash(
                    '質問を更新できませんでした',
                    'default'
                );
            }    
        }
    }

    public function delete()
    {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        } elseif ($this->request->is('post')) {
            $id = $this->request->data['Question']['id'];
            if ($this->Question->delete($id)) {
                $this->redirect($this->referer());
                $this->Session->setFlash(
                    '削除しました！',
                    'default'
                );
            }
        }
    }
}