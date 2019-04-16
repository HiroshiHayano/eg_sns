<?php

class QuestionsController extends AppController {
    public $helpers = array('Html', 'Form');
    public $uses = array('Question');

    public function isAuthorized($user = null)
    {
        // 登録済ユーザーの許可範囲
        if (in_array($this->action, array('index', 'add', 'resolve', 'edit', 'delete'))) {
            return true;
        }
    
        // // 自分自身のアカウントの許可範囲
        // if (in_array($this->action, array(
        //     'resolve', 
        //     ))) {
        //     $page_id = (int)$this->request->params['pass'][0];
        //     // 自身のページか判別
        //     if ($this->User->isOwnedBy($page_id, (int)$user['id'])) {
        //         return true;
        //     }
        // }
    
        return parent::isAuthorized($user);
    }

    public function index()
    {
        $this->autoLayout = false;
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
        // // 共有知識
        // $this->set('knowledges', $this->Knowledge->find('all'), array(
        //     'order' => array('id' => 'desc'),
        // ));
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