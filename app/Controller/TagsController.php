<?php

class TagsController extends AppController {
    public $uses = ['Tag', 'KnowledgesTag'];
    public function isAuthorized($user = null)
    {
        // 登録済ユーザーの許可範囲
        if (in_array($this->action, array(
            'add', 
            ))) {
            return true;
        }
        return parent::isAuthorized($user);
    }

    public function add($knowledge_id)
    {
        if ($this->request->is('post')) {
            if (!in_array($this->request->data['Tag']['label'], $this->Tag->find('list', ['fields' => 'label']), TRUE)){
                if (!$this->Tag->save($this->request->data)) {
                    $this->Session->setFlash(
                        '不正な入力です',
                        'default',
                        ['class' => 'alert alert-danger']
                    );
                    $this->redirect($this->referer());
                }
            }
            $tag = $this->Tag->find('first', [
                'conditions' => [
                    'label' => $this->request->data['Tag']['label']
                    ]
                ]
            );
            // Knowledges_Tagsに追加
            $conditions = [
                'knowledge_id' => $knowledge_id,
                'tag_id' => $tag['Tag']['id']
            ];
            $data = [
                'KnowledgesTag' => $conditions,
            ];
            // すでに付加されているか確認
            if ($this->Tag->isNotAddedTag($conditions)) {
                // 最大付加タグ数を超えていないか確認
                if (!$this->Tag->isExeedMaxNumberOfTag($knowledge_id)) {
                    if ($this->KnowledgesTag->save($data)) {
                        $this->Session->setFlash(
                            'タグを追加しました',
                            'default',
                            ['class' => 'alert alert-success']
                        );
                        $this->redirect([
                            'controller' => 'knowledges', 
                            'action' => 'view', 
                            $knowledge_id,
                        ]);
                    } else {
                        $this->Session->setFlash(
                            'タグを追加に失敗しました',
                            'default',
                            ['class' => 'alert alert-danger']
                        );
                        $this->redirect($this->referer());
                    }                    
                } else {
                    $this->Session->setFlash(
                        '付加可能なタグの数は'.$this->KnowledgesTag->maxNumberOfTag.'個までです',
                        'default',
                        ['class' => 'alert alert-danger']
                    );
                    $this->redirect($this->referer());
                }
            } else {
                $this->Session->setFlash(
                    'すでにタグがついてます',
                    'default',
                    ['class' => 'alert alert-danger']
                );
                $this->redirect($this->referer());
            }
        }
    }
}