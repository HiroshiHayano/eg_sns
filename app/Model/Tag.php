<?php

class Tag extends AppModel {
    //validation
    public $validate = [
        'title' => array(
            'rule1' => [
                'rule' => 'notEmpty',
                'message' => '入力してください'    
            ],
            // 'rule2' => [
            //     'rule' => ['checkSpace', 'title'],
            //     'message' => '全角・半角スペースのみはダメ'
            // ]
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
}