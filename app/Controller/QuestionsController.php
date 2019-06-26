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
    public $presetVars = [
        'keyword' => ['type' => 'value', 'empty' => true, 'encode' => true],
        'user_id' => ['type' => 'checkbox', 'empty' => true, 'encode' => true],
        'status_filter' => ['type' => 'checkbox', 'empty' => true, 'encode' => true],
    ];

    public function isAuthorized($user = null)
    {
        // 登録済ユーザーの許可範囲
        if (in_array($this->action, array(
            'index', 
            'view', 
            'add', 
            'resolve', 
            'edit', 
            'delete', 
            'questions_view', 
            'answered_questions_view'))) {
                return true;
        }
        return parent::isAuthorized($user);
    }

    public function index()
    {
        if ($this->request->is('post')){
            array_walk_recursive($this->request->data, [$this->Question, 'shapeCondition']);
            $this->Question->set($this->request->data);
            if (!$this->Question->validates()) {
                $this->Session->setFlash(
                    '検索ワードを見直してください',
                    'default',
                    ['class' => 'alert alert-danger']
                );
            } else {
                $this->Prg->commonProcess();
            }    
        } else {
            $this->Prg->commonProcess();
            $conditions = $this->Question->parseCriteria($this->passedArgs);
            $this->paginate['conditions'] = $conditions;
        }
        $this->set('questions', $this->paginate());

        $users = $this->User->find('list', ['field' => 'name']);
        $this->set(compact('users'));
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

            $users = $this->User->find('list', ['field' => 'name']);
            $this->set(compact('users'));    
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
                $this->redirect($this->referer());
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
                $this->redirect($this->referer());
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
                $this->redirect($this->referer());
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

    public function answered_questions_view($id = NULL)
    {
        $this->set('user', $this->User->find('first', ['conditions' => ['User.id' => $id]]));

        $conditions = [
            'Answer.user_id' => $id,
        ];
        $this->set('answers', $this->paginate('Answer', $conditions));

        $users = $this->User->find('list', ['field' => 'name']);
        $this->set(compact('users'));    
    }
}