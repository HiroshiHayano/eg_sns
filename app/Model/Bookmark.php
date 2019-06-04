<?php

class Bookmark extends AppModel {
    //validation
    public $validate = [];

    public $belongsTo = [
        'User' => [
            'className' => 'User',
            'foreignKey' => 'user_id',
            'counterCache' => true,
        ],
        'Knowledge' => [
            'className' => 'Knowledge',
            'foreignKey' => 'knowledge_id',
            'counterCache' => true,
        ],
    ];
}