<?php

class Knowledge extends AppModel {
    //validation
    public $validate = array(
        'title' => array(
            'rule1' => [
                'rule' => 'notEmpty',
                'message' => '入力してください'    
            ],
            'rule2' => [
                'rule' => ['checkSpace', 'title'],
                'message' => '全角・半角スペースのみはダメ'
            ]
        ),
        'content' => array(
            'rule1' => [
                'rule' => 'notEmpty',
                'message' => '入力してください'    
            ],
            'rule2' => [
                'rule' => ['checkSpace', 'content'],
                'message' => '全角・半角スペースのみはダメ'
            ]
        ),
        'keyword' => [
            'rule1' => [
                'rule' => ['checkSpace', 'keyword'],
                'message' => '全角・半角スペースのみはダメ',
                'allowEmpty' => true,
            ],
        ],
        'name' => [
            'rule1' => [
                'rule' => ['checkSpace', 'name'],
                'message' => '全角・半角スペースのみはダメ',
                'allowEmpty' => true,
            ],
        ]
    );

    public $belongsTo = [
        'User' => [
            'className' => 'User',
            'foreignKey' => 'user_id',
            'counterCache' => true,
        ]
    ];

    public $hasMany = [
        'KnowledgesComment' => ['dependent' => true],
        'Bookmark' => ['dependent' => true],
    ];

    public $hasAndBelongsToMany =[
        'Tag' => [
            'classname' => 'Tag',
            'joinTable' => 'knowledges_tags',
            'foreignKey' => 'knowledge_id',
            'associationForeignKey' => 'tag_id',
            'with' => 'KnowledgesTag',
        ]
    ];

    public $actsAs = array('Search.Searchable');
    public $filterArgs = array(
        'keyword' => [
            'type' => 'like',
            'field' => array(
                'Knowledge.title', 
                'Knowledge.content', 
            ),
            'connectorAnd' => null,
            'connectorOr' => ' ',
        ],
        'name' => [
            'type' => 'like',
            'field' => [
                'User.name',
                'User.phonetic'
            ],
            'connectorAnd' => null,
            'connectorOr' => ' ',
        ]
    );
}