<?php

class QuestionsController extends AppController {
    public $helpers = array('Html', 'Form');
    public $uses = array('Question');

    public function isAuthorized($user = null)
    {
        // 登録済ユーザーの許可範囲
        if (in_array($this->action, array('add', 'resolve', 'edit', 'delete'))) {
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

    public function resolve()
    {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        } elseif ($this->request->is('post')) {
            // debug($this->request->data);
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
        $this->Question->id = $id;

        if ($this->request->is('get')) {
            $this->request->data = $this->Question->read();
        } else {
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