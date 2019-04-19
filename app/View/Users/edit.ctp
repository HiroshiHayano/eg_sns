<?php
    echo $this->Html->css('index_users');
    echo $this->element('head', array('title' => 'プロフィール編集'));
    echo $this->element('header');
?>

<div>
    <h2>プロフィール編集</h2>
    <div>
        <h3>
            <?php 
                echo $this->Html->link('プロフィール画像の変更', array(
                    'action'=>'edit_image', 
                    $this->Session->read('Auth.User.id')
                )); 
            ?>
        </h3>
        <?php
            echo $this->Form->create('User');
            echo $this->Form->input('name', array(
                'label' => array('text' => '名前'),
                'placeholder' => '例）山田 太郎'
            ));
            echo $this->Form->input('phonetic', array(
                'label' => array('text' => 'よみがな'),
                'placeholder' => '例）やまだ たろう'
            ));
            echo $this->Form->input('department_id', array(
                'options' => $departments,
                'label' => array('text' => '部署を選択')
            ));
            echo $this->Form->input('mail_address', array(
                'label' => array('text' => 'メールアドレス')
            ));
            echo $this->Form->input('birthday', array(
                'label' => array('text' => '誕生日'),
                'monthNames' => false,
                'dateFormat'=>'YMD',
                'minYear' => date('Y') - 80,
                'maxYear' => date('Y'),
            ));
            echo $this->Form->input('birthplace', array(
                'label' => array('text' => '出身'),
                'placeholder' => '都道府県名を入力'
            ));
            echo $this->Form->input('hobby', array(
                'type' => 'textarea',
                'label' => array('text' => '趣味'),
                'placeholder' => '自由記入'
            ));
            echo $this->Form->input('message', array(
                'type' => 'textarea',
                'label' => array('text' => '目標'),
                'placeholder' => '自由記入'
            ));
            echo $this->Form->button(__('更新'), array()); 
            echo $this->Form->end(); 
        ?>
    </div>
</div>

<div>
    <h3>
        <?php 
            echo $this->Html->link('パスワードの変更', array(
                'action'=>'edit_password', 
                $this->Session->read('Auth.User.id')
            )); 
        ?>
    </h3>
    <h3>
        <?php 
            echo $this->Form->create('User', array(
                'onsubmit' => 'return confirm("アカウントを削除しますか？")',
                'url' => array(
                    'controller' => 'users',
                    'action' => 'delete',
                )
            ));
            echo $this->Form->input('id', array(
                'type' => 'hidden',
                'value' => $this->Session->read('Auth.User.id'),
            ));
            echo $this->Form->input('name', array(
                'type' => 'hidden',
                'value' => $this->Session->read('Auth.User.name') . '(退会済み)',
            ));
            echo $this->Form->input('is_deleted', array(
                'type' => 'hidden',
                'value' => true,
            ));
            echo $this->Form->input('image', array(
                'type' => 'hidden',
                'value' => 'mark_question.png',
            ));
            echo $this->Form->submit('アカウントの削除');
            echo $this->Form->end();
        ?>
    </h3>
</div>