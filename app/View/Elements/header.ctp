<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
        <?php 
            echo $this->Html->link('My Profile', array(
                    'controller' => 'users', 
                    'action'=>'view',
                    $this->Session->read('Auth.User.id'),
                ), [
                    'class' => ['navbar-brand']
                ]
            ); 
        ?>
    </div>
    <ul class="nav navbar-nav">
        <li>
            <?php
                echo $this->Html->link('Member', array(
                    'controller' => 'users', 
                    'action'=>'index',
                )); 
            ?>
        </li>
        <li>
            <?php
                echo $this->Html->link('Questions', array(
                    'controller' => 'questions', 
                    'action'=>'index',
                )); 
            ?>
        </li>
        <li>
            <?php
                echo $this->Html->link('Knowledges', array(
                    'controller' => 'knowledges', 
                    'action'=>'index',
                )); 
            ?>
        </li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li>
        <?php
            echo $this->Html->link(
                $this->Html->tag('span', 'Logout', ['class' => ['glyphicon glyphicon-log-out']]), 
                [
                    'controller' => 'users', 
                    'action'=>'logout',
                ],
                [
                    'escape' => false,
                    'confirm' => 'ログアウトしてよろしいですか?'
                ]
            ); 
        ?>
      </li>
    </ul>
  </div>
</nav>
<!-- 以下位置調整のためのカサ増し -->
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
        <?php 
            echo $this->Html->link('My Profile', array(
                    'controller' => 'users', 
                    'action'=>'view',
                    $this->Session->read('Auth.User.id'),
                ), [
                    'class' => ['navbar-brand']
                ]
            ); 
        ?>
    </div>
    <ul class="nav navbar-nav">
        <li>
            <?php
                echo $this->Html->link('Member', array(
                    'controller' => 'users', 
                    'action'=>'index',
                )); 
            ?>
        </li>
        <li>
            <?php
                echo $this->Html->link('Questions', array(
                    'controller' => 'questions', 
                    'action'=>'index',
                )); 
            ?>
        </li>
        <li>
            <?php
                echo $this->Html->link('Knowledges', array(
                    'controller' => 'knowledges', 
                    'action'=>'index',
                )); 
            ?>
        </li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li>
        <?php
            echo $this->Html->link(
                $this->Html->tag('span', 'Logout', ['class' => ['glyphicon glyphicon-log-out']]), 
                [
                    'controller' => 'users', 
                    'action'=>'logout',
                ],
                [
                    'escape' => false,
                    'confirm' => 'ログアウトしてよろしいですか?'
                ]
            ); 
        ?>
      </li>
    </ul>
  </div>
</nav>
<!-- カサ増しここまで -->
<?php echo $this->Session->flash(); ?>
