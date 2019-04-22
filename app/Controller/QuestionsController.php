<?php

class QuestionsController extends AppController {
    public $autoLayout = false;

    public $helpers = array('Html', 'Form');
    public $uses = array('Question', 'Knowledge', 'Answer', 'Comment', 'User');
    public $components = ['UsersList'];

    public function isAuthorized($user = null)
    {
        // 登録済ユーザーの許可範囲
        if (in_array($this->action, array('index', 'view', 'add', 'resolve', 'edit', 'delete'))) {
            return true;
        }
        return parent::isAuthorized($user);
    }

    public function index()
    {
        $number_of_element = null;
        // 未解決
        $this->set('not_resolved_questions', $this->Question->find('all', array(
            'conditions' => array('is_resolved' => '0'),
            'order' => array('id' => 'desc'),
            'limit' => $number_of_element,
        )));
        // 解決済み
        $this->set('resolved_questions', $this->Question->find('all', array(
            'conditions' => array('is_resolved' => '1'),
            'order' => array('id' => 'desc'),
            'limit' => $number_of_element,
        )));
        // 共有知識
        $this->set('knowledges', $this->Knowledge->find('all', array(
            'order' => array('id' => 'desc'),
            'limit' => $number_of_element,
        )));
        $this->set('title_len', 25);
        $this->set('content_len', 50);
    }

    public function view($id=NULL)
    {
        $question = $this->Question->find('first', array( // 現在はとりあえず一件だけ表示するためにfirstにしている
            'conditions' => array(
                'id' => $id,
            )
        ));
        $this->set('question', $question);
        if (!empty($question)) {
            $this->Question->id = $question['Question']['id'];
            $this->request->data = $this->Question->read();

            // ユーザーの顔画像パス一覧取得
            $this->set('users_image', $this->UsersList->getImages());
            // ユーザーの名前一覧取得
            $this->set('users_name', $this->UsersList->getNames());

            $answers = $this->Answer->find('all', array(
                'conditions' => array(
                    'question_id' => $question['Question']['id'],
                )
            ));
            $this->set('answers', $answers);
    
            $answers_id = array();
            foreach ($answers as $answer) {
                $answers_id[] = $answer['Answer']['id'];
            }
            $comments = array();
            foreach ($answers_id as $answer_id) {
                $comments_set = array();
                $comments_set += $this->Comment->find('all', array(
                    'conditions' => array(
                        'answer_id' => $answer_id,
                    )
                ));
                $comments += array($answer_id => $comments_set);
            }
            $this->set('comments', $comments);
        }
    }

    public function resolve()
    {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        } elseif ($this->request->is('post')) {
            if ($this->Question->save($this->request->data)) {
                $this->Session->setFlash(
                    '質問解決しました',
                    'default'
                );
                $this->redirect($this->referer());
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
                $this->Session->setFlash(
                    '質問投稿しました',
                    'default'
                );
                $this->redirect($this->referer());
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
                $this->Session->setFlash(
                    '質問を更新しました',
                    'default'
                );
                $this->redirect($this->referer());
            } else {
                $this->Session->setFlash(
                    '質問を更新できませんでした',
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
        if ($this->Question->delete($id)) {
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