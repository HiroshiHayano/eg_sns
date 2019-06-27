<?php

class Tag extends AppModel {
    //validation
    public $validate = [
        'label' => array(
            'rule1' => [
                'rule' => 'notEmpty',
                'message' => '入力してください'    
            ],
            'rule2' => [
                'rule' => ['between', 1, 45], // pneumonoultramicroscopicsilicovolcanoconiosis
                'message' => '1文字以上、45文字以下でお願いします'
            ],
            'rule3' => [
                'rule' => ['checkSpace', 'label'],
                'message' => '全角・半角スペースのみはダメ'
            ]
        ),
    ];

    public $hasAndBelongsToMany = [
        'Knowledge' => [
            'classname' => 'Knowledge',
            'joinTable' => 'knowledges_tags',
            'foreignKey' => 'tag_id',
            'associationForeignKey' => 'knowledge_id',
            'with' => 'KnowledgesTag',
        ]
    ];

    public function isNotAddedTag($conditions)
    {
        return $this->KnowledgesTag->find('count', ['conditions' => $conditions]) === 0;
    }

    public function isExeedMaxNumberOfTag($knowledge_id)
    {
        return $this->KnowledgesTag->find('count', ['conditions' => ['KnowledgesTag.knowledge_id' => $knowledge_id]]) >= $this->KnowledgesTag->maxNumberOfTag;
    }
}