<?php

App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {
    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash(
                $this->data[$this->alias]['password']
            );
        }
        return true;
    }

    //validation
    public $validate = array(
        'mail_address' => array(
            'mail_address_rule_2' => array(
                'rule' => 'isUnique',
                'message' => 'すでに使用されているメールアドレスです'    
            ),
            'mail_address_rule_1' => array(
                'rule' => 'email',
                'message' => 'メールアドレスのフォーマットを確認してください'    
            ),
        ),
        'password' => array(
            'password_rule_1' => array(
                'rule' => array('minLength', '7'),
                'message' => '7文字以上で登録してください'
            ),
            'password_rule_2' => array(
                'rule' => 'passwordConfirm',
                'message' => 'パスワードが一致していません'
            ),
        ),
        'password_confirm' => array(
            'rule' => 'notEmpty',
            'message' => '入力は必須です'
        ),
        'name' => array(
            'rule' => 'notEmpty',
            'message' => '入力は必須です'
        ),
        'phonetic' => array(
            'rule' => 'notEmpty',
            'message' => '入力は必須です'
        ),
        'birthday' => array(
            'rule' => 'notEmpty',
            'message' => '入力は必須です'
        ),
        'birthplace' => array(
            'rule' => 'notEmpty',
            'message' => '入力は必須です'
        ),
        'department_id' => array(
            'rule' => 'notEmpty',
            'message' => '入力は必須です'
        ),
        'image'=>array(
            'upload-file' => array( 
                'rule' => 'uploadError',
                'message' => array( 'ファイルアップロードで障害が起こりました。')
            ),
            'extension' => array(
                'rule' => array('extension', array( 
                        'jpg', 'jpeg', 'png'
                    )  // 拡張子を配列で定義
                ),
                'message' => array('画像（jpg, jpeg, png）を選択してください'),
            ),
            'mimetype' => array( 
                'rule' => array('mimeType', array('image/jpg', 'image/jpeg', 'image/png')),
                'message' => array('MIME型が不正です')
            ),
            'maxFileSize' => array( 
                'rule' => array('fileSize', '<=', '1MB'),  // 1MB以下
                'message' => array('サイズ5MB以下の画像を選択してください')
            ),
            'minFileSize' => array( 
                'rule' => array('fileSize', '>',  0),// 0バイトより大
                'message' => array('file size error')
            ),
        ),
    );

    public function passwordConfirm($check)
    {
        //２つのパスワードフィールドが一致する事を確認する
        if($this->data['User']['password'] === $this->data['User']['password_confirm']) {
            return true;
        } else {
            return false;
        }
    }

    // 自身のページであるか判別
    public function isOwnedBy($page_id, $user_id)
    {
        return $page_id === $user_id;
    }
}