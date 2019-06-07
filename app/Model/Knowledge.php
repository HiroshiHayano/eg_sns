<?php

class Knowledge extends AppModel {
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

    public $belongsTo = [
        'User' => [
            'className' => 'User',
            'foreignKey' => 'user_id',
            'counterCache' => true,
        ]
    ];

    public $hasMany = [
        'KnowledgesComment',
        'Bookmark',
    ];

    public $actsAs = array('Search.Searchable');
    public $filterArgs = array(
        'keyword' => array(
            'type' => 'like',
            'field' => array(
                'Knowledge.title', 
                'Knowledge.content', 
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