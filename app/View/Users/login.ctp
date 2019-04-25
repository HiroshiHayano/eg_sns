<?php
    echo $this->Html->css('login');
    echo $this->element('head', array('title' => 'ログイン'));
    echo $this->Session->flash();
?>

<div class="text-center">
    <?php 
        echo $this->Session->flash(); 
    ?>
</div>

<div class='container text-right'>
    <h3>
        <?php 
            echo $this->Html->link('新規登録', array(
                'controller' => 'users',
                'action' => 'add'
            )); 
        ?>
    </h3>
</div>

<div class='container well'>
    <h2><?php echo h('Login'); ?></h2>
    <div>
        <?php
            echo $this->Form->create('User');
            echo $this->Form->input('mail_address', [
                'label' => 'email:',
                'class' => 'form-control'
            ]);
            echo $this->Form->input('password', [
                'label' => 'password:',
                'class' => 'form-control',
            ]);
            echo $this->Form->button('Login', [
                'class' => 'btn btn-default btn-lg'
            ]);
            echo $this->Form->end();
        ?>
    </div>
</div>
