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
}