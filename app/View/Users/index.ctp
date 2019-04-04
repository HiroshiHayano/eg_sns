<?php
    echo $this->Html->css('index');
    // echo $this->Html->css('skyblue');
    echo $login_user['name'] . 'さん こんにちは！';
?>
<h2>社員一覧</h2>

<div>
    <?php foreach ($users as $user) : ?>
        <div class='icon'>
            <?php 
                echo $this->Html->image('icon/' . $user['User']['image'], array(
                    'url' => array(
                        'controller' => 'users', 
                        'action' => 'view', 
                        $user['User']['id']
                    )
                ));
            ?>
            <div class="name">
                <?php
                    echo h($user['User']['name']);
                ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
