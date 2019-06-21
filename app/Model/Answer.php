<?php

class Answer extends AppModel {
    //validation
    public $validate = array(
        'content' => array(
            'rule' => 'notEmpty',
            'message' => '入力してください'
        ),    
    );

    public $hasMany = [
        'Comment' => ['dependent' => true],
    ];

    public $belongsTo = [
        'Question' =>[
            'counterCache' => true,
        ],
        'User' => [
            'counterCache' => true,
        ]
    ];

    public $actsAs = ['Search.Searchable'];
    public $filterArgs = [
        'answered_user_id' => [
            'type' => 'value',
            'field' => [
                'User.id',
            ],
            'connectorAnd' => '+',
            'connectorOr' => ',',
            'presetType' => 'value',
        ],
    ];
}