<?php

class KnowledgesController extends AppController {
    public $autoLayout = false;

    public $helpers = array('Html', 'Form', 'Text', 'Paginator', 'UploadPack.Upload');
    public $uses = array('Knowledge', 'KnowledgesComment', 'User', 'Bookmark');
    public $components = ['UsersList'];
    public $paginate = [
        'limit' => 10,
        'order' => ['id' => 'desc'],
        'conditions' => [
            'OR' => []
        ]
    ];

    public function isAuthorized($user = null)
    {
        // 登録済ユーザーの許可範囲
        if (in_array($this->action, array('index', 'view', 'add', 'edit', 'delete', 'knowledges_view'))) {
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
            $this->set('number_of_knowledges', $this->Knowledge->find('count', [
                'conditions' => $conditions,
            ]));
        } else {
            $this->Session->write('Conditions', []);
            $this->set('query', '');
        }
        $this->set('knowledges', $this->paginate('Knowledge', $this->Session->read('Conditions')));
        $bookmarks = Hash::extract($this->Bookmark->find('all', [
            'conditions' => ['Bookmark.user_id' => SessionComponent::read('Auth.User.id')],
            'fields' => 'Bookmark.knowledge_id'
        ]), '{n}.Bookmark.knowledge_id');
        $this->set(compact('bookmarks'));
    }

    public function view($id = NULL)
    {
        $knowledge = $this->Knowledge->find('first', array(
            'conditions' => array(
                'Knowledge.id' => $id,
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
        $this->set('users_image', $this->UsersList->getImages());
        // ユーザーの名前一覧取得
        $this->set('users_name', $this->UsersList->getNames());
        $bookmarks = Hash::extract($this->Bookmark->find('all', [
            'conditions' => ['Bookmark.user_id' => SessionComponent::read('Auth.User.id')],
            'fields' => 'Bookmark.knowledge_id'
        ]), '{n}.Bookmark.knowledge_id');
        $this->set(compact('bookmarks'));
    }

    public function add()
    {   
        if ($this->request->onlyAllow(['post'])) {
            if ($this->Knowledge->save($this->request->data)) {
                $this->Session->setFlash(
                    '投稿しました',
                    'default',
                    ['class' => 'alert alert-success']
                );
                $this->redirect($this->referer());
            } else {
                $this->Session->setFlash(
                    '投稿できませんでした',
                    'default',
                    ['class' => 'alert alert-danger']
                );
            } 
        }
    }

    public function edit()
    {
        if ($this->request->onlyAllow(['post'])) {
            if ($this->Knowledge->save($this->request->data)) {
                $this->Session->setFlash(
                    '更新しました',
                    'default',
                    ['class' => 'alert alert-success']
                );
                $this->redirect($this->referer());
            } else {
                $this->Session->setFlash(
                    '更新できませんでした',
                    'default',
                    ['class' => 'alert alert-danger']
                );
            }
        }
    }

    public function delete($id)
    {
        if ($this->request->onlyAllow(['post'])) {
            if ($this->Knowledge->delete($id)) {
                $this->Session->setFlash(
                    '削除しました！',
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

    public function knowledges_view($id = NULL)
    {
        $this->User->id = $id;
        $this->set('user', $this->User->read());

        $conditions['user_id'] = $this->User->id;
        $this->set('knowledges', $this->paginate('Knowledge', $conditions));
    }
}