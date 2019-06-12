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

    public $actsAs = array('Search.Searchable');
    public $filterArgs = array(
        'keyword' => array(
            'type' => 'like',
            'field' => array(
                'Question.title', 
                'Question.content', 
            ),
            'connectorAnd' => '+',
            'connectorOr' => ',',
        ),
        'name' => [
            'type' => 'like',
            'field' => [
                'User.name',
                'User.phonetic'
            ],
            'connectorAnd' => '+',
            'connectorOr' => ',',
        ]
    );
}