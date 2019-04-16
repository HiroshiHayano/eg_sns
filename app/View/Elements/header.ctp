<header>
    <div>
        <?php 
            echo $this->Html->link('My Profile', array(
                'controller' => 'users', 
                'action'=>'view',
                $this->Session->read('Auth.User.id'),
            )); 
        ?>
    </div>
    <div>
        <?php
            echo $this->Html->link('社員一覧', array(
                'controller' => 'users', 
                'action'=>'index',
            )); 
        ?>
    </div>
    <div>
        <?php
                echo $this->Html->link('質問一覧', array(
                'controller' => 'questions', 
                'action'=>'index',
            )); 
        ?>
    </div>
    <div>
        <?php
                echo $this->Html->link('ログアウト', array(
                'controller' => 'users', 
                'action'=>'logout',
            )); 
        ?>
    </div>
</header>