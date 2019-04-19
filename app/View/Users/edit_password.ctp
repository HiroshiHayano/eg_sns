<?php
    echo $this->element('head', array('title' => 'パスワードの変更'));
    echo $this->element('header');
?>

<h3>
    <?php 
        echo $this->Html->link('プロフィールの変更に戻る', array('action'=>'edit', $this->Session->read('Auth.User.id'))); 
    ?>
</h3>

<h1>パスワード更新</h1>
<div>
    <?php
        echo $this->Form->create('User');
        echo $this->Form->input('password', array(
            'label' => array('text' => 'パスワード'),
            'placeholder' => '７文字以上',
        ));
        echo $this->Form->input('password_confirm', array(
            'label' => array('text' => 'パスワード(確認用)'),
            'placeholder' => '同じパスワードを入力',
            'type' => 'password',
        ));
        echo $this->Form->button(__('更新'), array()); 
        echo $this->Form->end(); 
    ?>
</div>