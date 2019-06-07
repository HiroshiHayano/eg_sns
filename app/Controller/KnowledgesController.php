<?php

class KnowledgesController extends AppController {
    public $autoLayout = false;

    public $helpers = array('Html', 'Form', 'Text', 'Paginator', 'UploadPack.Upload');
    public $uses = array('Knowledge', 'KnowledgesComment', 'User', 'Bookmark');
    public $components = ['UsersList', 'GetBookmarks', 'Search.Prg'];
    public $presetVars = true;

    public $paginate = [
        // 'contain' => ['KnowledgesComment', 'Bookmark'],
        'limit' => 10,
        'order' => ['id' => 'desc'],
        // conditionはsearchプラグイン導入後に削除 
        // 'conditions' => [
        //     'OR' => []
        // ]
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
        $this->Prg->commonProcess();
        $conditions = $this->Knowledge->parseCriteria($this->passedArgs);
        $this->paginate['conditions'] = $conditions;
        $this->set('knowledges', $this->paginate());
        $bookmarks = $this->GetBookmarks->getLoginUsersBookmarks(); //bookmarkしてるknowledge_idを取得
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
        $bookmarks = $this->GetBookmarks->getLoginUsersBookmarks(); //bookmarkしてるknowledge_idを取得
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
        $bookmarks = $this->GetBookmarks->getLoginUsersBookmarks(); //bookmarkしてるknowledge_idを取得
        $this->set(compact('bookmarks'));
    }

    public function bookmarked_knowledges_view($id = NULL)
    {
        $this->set('user', $this->User->find('first', ['conditions' => ['User.id' => $id]]));

        $this->Prg->commonProcess();
        $conditions = $this->Bookmark->parseCriteria($this->passedArgs);
        $this->set('knowledges', $this->paginate('Bookmark', $conditions));

        $bookmarks = $this->GetBookmarks->getLoginUsersBookmarks(); //bookmarkしてるknowledge_idを取得
        $this->set(compact('bookmarks'));
    }
}