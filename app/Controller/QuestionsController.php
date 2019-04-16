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
                $this->Flash->set(
                    '質問解決しました',
                    array('element' => 'success')
                );
            } else {
                $this->Flash->set(
                    'エラーが起きました',
                    array('element' => 'error')
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
                $this->Flash->set(
                    '質問投稿しました',
                    array('element' => 'success')
                );
            } else {
                $this->Flash->set(
                    '質問投稿できませんでした',
                    array('element' => 'error')
                );
            } 
        }
    }

    public function edit()
    {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        } elseif ($this->request->is('post')) {
            if ($this->Question->save($this->request->data)) {
                $this->redirect($this->referer());
                $this->Flash->set(
                    '質問を更新しました',
                    array('element' => 'success')
                );
            } else {
                $this->Flash->set(
                    '質問を更新できませんでした',
                    array('element' => 'error')
                );
            }    
        } else {
            debug($this->request->param);
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
                $this->Flash->set(
                    '削除しました！',
                    array('element' => 'success')
                );
            }
        }
    }
}