<?php

App::uses('Component', 'Controller');

class UsersListComponent extends Component
{
    public function initialize(Controller $controller) {
        $this->controller = $controller;
    }

    public function getImages()
    {
        $images = $this->controller->User->find(
            'list', array(
                'fields' => array(
                    'image'
                )
            )
        );
        return $images;
    }

    public function getNames()
    {
        $names = $this->controller->User->find(
            'list', array(
                'fields' => array(
                    'name'
                )
            )
        );
        return $names;
    }
}