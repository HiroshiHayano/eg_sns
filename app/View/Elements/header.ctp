<header class='container'>
    <div class='row'>
        <div class='col-md-12'>
            <?php
                echo $this->Session->read('Auth.User.name') . 'さん こんにちは！';
            ?>
        </div>
    </div>
    <div class='row'>
        <div class='col-md-3'>
            <?php 
                echo $this->Html->link('My Profile', array(
                    'controller' => 'users', 
                    'action'=>'view',
                    $this->Session->read('Auth.User.id'),
                )); 
            ?>
        </div>
        <div class='col-md-3'>
            <?php
                echo $this->Html->link('社員一覧', array(
                    'controller' => 'users', 
                    'action'=>'index',
                )); 
            ?>
        </div>
        <div class='col-md-3'>
            <?php
                    echo $this->Html->link('質問一覧', array(
                    'controller' => 'questions', 
                    'action'=>'index',
                )); 
            ?>
        </div>
        <div class='col-md-3'>
            <?php
                    echo $this->Html->link('ログアウト', array(
                    'controller' => 'users', 
                    'action'=>'logout',
                )); 
            ?>
        </div>
    </div>
</header>
<div>
    <?php echo $this->Session->flash(); ?>
</div>
