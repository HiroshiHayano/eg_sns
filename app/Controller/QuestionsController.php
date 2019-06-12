<?php

class QuestionsController extends AppController {
    public $autoLayout = false;

    public $helpers = array('Html', 'Form', 'UploadPack.Upload');
    public $uses = array('Question', 'Knowledge', 'Answer', 'Comment', 'User');
    public $components = ['UsersList', 'Search.Prg'];
    public $paginate = [
        'limit' => 10,
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
        $this->Prg->commonProcess();
        $conditions = $this->Question->parseCriteria($this->passedArgs);
        $this->paginate['conditions'] = $conditions;
        $this->set('questions', $this->paginate());
    }

    public function view($id=NULL)
    {
        $question = $this->Question->find('first', array( // 現在はとりあえず一件だけ表示するためにfirstにしている
            'conditions' => array(
                'Question.id' => $id,
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
        if ($this->request->onlyAllow(['post'])) {
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
        if ($this->request->onlyAllow(['post'])) {
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
        if ($this->request->onlyAllow(['post'])) {
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
        if ($this->request->onlyAllow(['post'])) {
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
    }

    public function questions_view($id = NULL)
    {
        $this->User->id = $id;
        $this->set('user', $this->User->read());

        $conditions['user_id'] = $this->User->id;
        $this->set('questions', $this->paginate('Question', $conditions));
    }
}