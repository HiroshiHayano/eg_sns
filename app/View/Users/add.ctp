<?php
    echo $this->Html->css('add');
    echo $this->element('head', array('title' => '新規登録'));
?>

<div>
    <h1>
        <?php 
            echo $this->Html->link('ログイン', array(
                'controller' => 'users',
                'action' => 'login'
            )); 
        ?>
    </h1>
</div>

<div>
    <h2><?php echo h('新規登録ページ'); ?></h2>
    <div>
        <?php
            echo $this->Form->create('User', array(
                'enctype' => 'multipart/form-data'
            ));
            echo $this->Form->input('mail_address', array(
                'label' => array('text' => 'メールアドレス')
            ));
            echo $this->Form->input('password', array(
                'label' => array('text' => 'パスワード'),
                'placeholder' => '７文字以上',
            ));
            echo $this->Form->input('password_confirm', array(
                'label' => array('text' => 'パスワード(確認用)'),
                'placeholder' => '同じパスワードを入力',
                'type' => 'password',
            ));
            echo $this->Form->input('name', array(
                'label' => array('text' => '名前'),
                'placeholder' => '例）山田 太郎'
            ));
            echo $this->Form->input('phonetic', array(
                'label' => array('text' => 'よみがな'),
                'placeholder' => '例）やまだ たろう'
            ));
            echo $this->Form->input('image', array(
                'label' => array('text' => 'プロフィール画像'), 
                'type' => 'file'
            ));
            echo $this->Form->input('department_id', array(
                'options' => $departments,
                'label' => array('text' => '部署を選択')
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
            echo $this->Form->button(__('登録'), array()); 
            echo $this->Form->end(); 
        ?>
    </div>
</div>