<?php

class KnowledgeComment extends AppModel {
    //validation
    public $validate = array(
        'content' => array(
            'rule' => 'notEmpty',
            'message' => '入力してください'
        ),
    );
}