<?php

class Answer extends AppModel {
    //validation
    public $validate = array(
        'content' => array(
            'rule' => 'notEmpty',
            'message' => '入力してください'
        ),    
    );

    public $belongsTo = [
        'Question' =>[
            'counterCache' => true,
        ],
        'User' => [
            'counterCache' => true,
        ]
    ];
}