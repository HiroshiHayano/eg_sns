<?php

class Question extends AppModel {
    //validation
    public $validate = array(
        'title' => array(
            'rule' => 'notEmpty',
            'message' => '入力してください'
        ),    
        'content' => array(
            'rule' => 'notEmpty',
            'message' => '入力してください'
        ),    
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
            'presetType' => 'value',
        ],
        'name' => [
            'type' => 'like',
            'field' => [
                'User.name',
                'User.phonetic'
            ],
            'connectorAnd' => '+',
            'connectorOr' => ',',
            'presetType' => 'value',
        ],
        'status_filter' => [
            'type' => 'value',
            'field' => 'Question.is_resolved',
            'presetType' => 'checkbox',
        ],
    ];
}