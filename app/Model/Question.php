<?php

class Question extends AppModel {
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

    public $hasMany = [
        'Answer' => [
            'foreignKey' => 'question_id'
        ]
    ];

    public $belongsTo = ['User' => [
        'className' => 'User',
        'foreignKey' => 'user_id',
        'counterCache' => true,
    ]];

    public $actsAs = ['Search.Searchable'];
    public $filterArgs = [
        'keyword' => [
            'type' => 'like',
            'field' => [
                'Question.title', 
                'Question.content', 
            ],
            'connectorAnd' => '+',
            'connectorOr' => ',',
        ],
        'name' => [
            'type' => 'like',
            'field' => [
                'User.name',
                'User.phonetic'
            ],
            'connectorAnd' => '+',
            'connectorOr' => ',',
        ],
        'status_filter' => [
            'type' => 'value',
            'field' => 'Question.is_resolved',
        ],
    ];
}