<?php

class Comment extends AppModel {
    //validation
    public $validate = array(
        'content' => array(
            'rule' => 'notEmpty',
            'message' => '入力してください'
        ),    
    );

    public $belongsTo = ['Answer' =>[
        'counterCache' => true,
    ]];
}