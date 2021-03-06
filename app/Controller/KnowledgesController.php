<?php

class KnowledgesController extends AppController {
    public $autoLayout = false;

    public $helpers = array('Html', 'Form', 'Text', 'Paginator', 'UploadPack.Upload');
    public $uses = array('Knowledge', 'KnowledgesComment', 'User', 'Bookmark', 'Tag');
    public $components = ['UsersList', 'GetBookmarks', 'Search.Prg'];
    public $presetVars = [
        'keyword' => ['type' => 'value', 'empty' => true, 'encode' => true],
        'user_id' => ['type' => 'checkbox', 'empty' => true, 'encode' => true],
        'tag_id' => ['type' => 'checkbox', 'empty' => true, 'encode' => true],
    ];

    public $paginate = [
        'limit' => 10,
        'order' => ['id' => 'desc'],
    ];

    public function isAuthorized($user = null)
    {
        // 登録済ユーザーの許可範囲
        if (in_array($this->action, array(
            'index', 
            'view', 
            'add', 
            'edit', 
            'delete', 
            'knowledges_view',
            'bookmarked_knowledges_view'
            ))) {
            return true;
        }
        return parent::isAuthorized($user);
    }

    public function index()
    {
        if ($this->request->is('post')){
            array_walk_recursive($this->request->data, [$this->Knowledge, 'shapeCondition']);
            $this->Knowledge->set($this->request->data);
            if (!$this->Knowledge->validates()) {
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
            $conditions = $this->Knowledge->parseCriteria($this->passedArgs);
            $this->paginate['conditions'] = $conditions;
        }
        $this->set('knowledges', $this->paginate());
        $bookmarks = $this->GetBookmarks->getLoginUsersBookmarks(); //bookmarkしてるknowledge_idを取得
        $this->set(compact('bookmarks'));

        $users = $this->User->find('list', ['fields' => 'name', 'order' => 'phonetic ASC']);
        $this->set(compact('users'));
        $tags = $this->Tag->find('list', ['fields' => 'label', 'order' => 'label ASC']);
        $this->set(compact('tags'));
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
        $bookmarks = $this->GetBookmarks->getLoginUsersBookmarks(); //bookmarkしてるknowledge_idを取得
        $this->set(compact('bookmarks'));

        $users = $this->User->find('list', ['fields' => 'name', 'order' => 'phonetic ASC']);
        $this->set(compact('users'));    
        $tags = $this->Tag->find('list', ['fields' => 'label', 'order' => 'label ASC']);
        $this->set(compact('tags'));
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
                $this->redirect($this->referer());
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
                $this->redirect($this->referer());
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

    public function bookmarked_knowledges_view($user_id = NULL)
    {
        $this->set('user', $this->User->find('first', ['conditions' => ['User.id' => $user_id]]));

        $user = $this->User->find('first', ['conditions' => ['User.id' => $user_id]]);
        $bookmarked_knowledge_id = Hash::extract($user, 'Knowledge.{n}.id');
        $conditions = [
            'Knowledge.id' => $bookmarked_knowledge_id,
        ];
        $this->set('bookmarked_knowledges', $this->paginate('Knowledge', $conditions));
        $bookmarks = $this->GetBookmarks->getLoginUsersBookmarks(); //bookmarkしてるknowledge_idを取得
        $this->set(compact('bookmarks'));

        $users = $this->User->find('list', ['fields' => 'name', 'order' => 'phonetic ASC']);
        $this->set(compact('users'));    
        $tags = $this->Tag->find('list', ['fields' => 'label', 'order' => 'label ASC']);
        $this->set(compact('tags'));
    }
}