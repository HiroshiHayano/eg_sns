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
}