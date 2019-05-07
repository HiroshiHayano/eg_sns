<?php

class QuestionsController extends AppController {
    public $autoLayout = false;

    public $helpers = array('Html', 'Form');
    public $uses = array('Question', 'Knowledge', 'Answer', 'Comment', 'User');
    public $components = ['UsersList'];
    public $paginate = [
        'limit' => 5,
        'order' => ['id' => 'desc'],
    ];

    public function isAuthorized($user = null)
    {
        // 登録済ユーザーの許可範囲
        if (in_array($this->action, array('index', 'view', 'add', 'resolve', 'edit', 'delete', 'questions_view'))) {
            return true;
        }
        return parent::isAuthorized($user);
    }

    public function index()
    {
        if (!empty($this->request->query)) {
            $conditions = [];
            $conditions['OR']['title LIKE'] = '%' . $this->request->query['query'] . '%';
            $conditions['OR']['content LIKE'] = '%' . $this->request->query['query'] . '%';
            $this->Session->write('Conditions', $conditions);
            $this->set('query', $this->request->query['query']);
            $this->set('number_of_questions', $this->Question->find('count', [
                'conditions' => $conditions,
            ]));
        } else {
            $this->Session->write('Conditions', []);
            $this->set('query', '');
        }
        $this->set('questions', $this->paginate('Question', $this->Session->read('Conditions')));
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
                    'default',
                    ['class' => 'alert alert-success']
                );
                $this->redirect($this->referer());
            } else {
                $this->Session->setFlash(
                    'エラーが起きました',
                    'default',
                    ['class' => 'alert alert-danger']
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
                    'default',
                    ['class' => 'alert alert-success']
                );
                $this->redirect($this->referer());
            } else {
                $this->Session->setFlash(
                    '質問投稿できませんでした',
                    'default',
                    ['class' => 'alert alert-danger']
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
                    'default',
                    ['class' => 'alert alert-success']
                );
                $this->redirect($this->referer());
            } else {
                $this->Session->setFlash(
                    '質問を更新できませんでした',
                    'default',
                    ['class' => 'alert alert-danger']
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
                '削除しました',
                'default',
                ['class' => 'alert alert-success']
            );
            $this->redirect(array(
                'controller' => 'questions',
                'action' => 'index'
            ));
        } else {
            $this->Session->setFlash(
                '削除できませんでした',
                'default',
                ['class' => 'alert alert-danger']
            );
            $this->redirect(array(
                'controller' => 'questions',
                'action' => 'index'
            ));
        }
    }

    public function questions_view($id = NULL)
    {
        $this->User->id = $id;
        $this->set('user', $this->User->read());

        $conditions['user_id'] = $this->User->id;
        $this->set('questions', $this->paginate('Question', $conditions));
    }
}