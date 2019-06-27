<?php

class Knowledge extends AppModel {
    //validation
    public $validate = array(
        'title' => array(
            'rule1' => [
                'rule' => 'notEmpty',
                'message' => '入力してください'    
            ],
            'rule2' => [
                'rule' => ['checkSpace', 'title'],
                'message' => '全角・半角スペースのみはダメ'
            ]
        ),
        'content' => array(
            'rule1' => [
                'rule' => 'notEmpty',
                'message' => '入力してください'    
            ],
            'rule2' => [
                'rule' => ['checkSpace', 'content'],
                'message' => '全角・半角スペースのみはダメ'
            ]
        ),
        'keyword' => [
            'rule1' => [
                'rule' => ['checkSpace', 'keyword'],
                'message' => '全角・半角スペースのみはダメ',
                'allowEmpty' => true,
            ],
        ],
    );

    public $belongsTo = [
        'PostUser' => [
            'className' => 'User',
            'foreignKey' => 'user_id',
            'counterCache' => true,
        ]
    ];

    public $hasMany = [
        'KnowledgesComment' => ['dependent' => true],
        // 'Bookmark' => ['dependent' => true],
    ];

    public $hasAndBelongsToMany =[
        'Tag' => [
            'classname' => 'Tag',
            'joinTable' => 'knowledges_tags',
            'foreignKey' => 'knowledge_id',
            'associationForeignKey' => 'tag_id',
            'with' => 'KnowledgesTag',
            'unique' => TRUE,
        ],
        'User' => [
            'classname' => 'User',
            'joinTable' => 'bookmarks',
            'foreignKey' => 'knowledge_id',
            'associationForeignKey' => 'user_id',
            'with' => 'Bookmark',
        ]
    ];

    public $actsAs = array('Search.Searchable', 'Containable');
    public $filterArgs = array(
        'keyword' => [
            'type' => 'like',
            'field' => array(
                'Knowledge.title', 
                'Knowledge.content', 
            ),
            'connectorAnd' => null,
            'connectorOr' => ' ',
        ],
        'user_id' => [
            'type' => 'value',
            'field' => [
                'PostUser.id',
            ],
        ],
        'tag_id' => [
            'type' => 'subquery',
            'method' => 'findByTags',
            'field' => 'Knowledge.id'
        ]
    );

    function findByTags($data = array()) {
        $this->KnowledgesTag->Behaviors->attach('Containable', ['autoFields' => false]);
        $this->KnowledgesTag->Behaviors->attach('Search.Searchable');

        $cond = $data['tag_id'];
        $query = $this->KnowledgesTag->getQuery('all', [
            'conditions' => ['KnowledgesTag.tag_id' => $cond],
            'fields' => ['knowledge_id'],
            'contain' => ['Tag']
            ]
        );
        return $query;
    }
}