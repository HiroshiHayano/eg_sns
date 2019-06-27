<?php

class KnowledgesTag extends AppModel {
    public $belongsTo = array(
        'Tag' => array(
            'className' => 'Tag',
            'foreignKey' => 'tag_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Knowledge' => array(
            'className' => 'Knowledge',
            'foreignKey' => 'knowledge_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
}