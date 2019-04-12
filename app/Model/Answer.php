<?php

class Answer extends AppModel {
    //validation
    public $validate = array(
        'content' => array(
            'rule' => 'notBlank',
            'message' => '入力してください'
        ),    
    );
}