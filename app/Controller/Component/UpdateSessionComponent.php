<?php
// Session情報の更新（プロフィールの変更があったときなどに使う）
App::uses('Component', 'Controller');

class UpdateSessionComponent extends Component
{
    // public $components = ['Sesstion', 'Auth'];
    public function initialize(Controller $controller) {
        $this->controller = $controller;
    }

    public function updateSession()
    {
        $user = $this->controller->User->find('first', array(
            'conditions' => array(
                'id' => CakeSession::read('Auth.User.id')
            ), 
            'recursive' => -1
        ));
        unset($user['User']['password']); // パスワードは除く
        CakeSession::write('Auth', $user); // Session情報を更新する
    }
}