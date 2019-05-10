<?php

class KnowledgesComment extends AppModel {
    //validation
    public $validate = array(
        'content' => array(
            'rule' => 'notEmpty',
            'message' => '入力してください'
        ),
    );

    public $belongsTo = ['Knowledge' =>[
        'counterCache' => true,
    ]];
}