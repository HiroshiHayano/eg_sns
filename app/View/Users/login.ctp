<?php
    echo $this->Html->css('login');
    echo $this->element('head', array('title' => 'ログイン'));
?>

<div class="text-center">
    <?php 
        echo $this->Session->flash(); 
    ?>
</div>

<div>
    <h1>
    <?php 
        echo $this->Html->link('新規登録', array(
            'controller' => 'users',
            'action' => 'add'
        )); 
    ?>
    </h1>
</div>

<div>
    <h2><?php echo h('ログインページ'); ?></h2>
    <div>
        <?php
            echo $this->Form->create('User');
            echo $this->Form->input('mail_address');
            echo $this->Form->input('password');
            echo $this->Form->button('ログイン');
            echo $this->Form->end();
        ?>
    </div>
</div>

