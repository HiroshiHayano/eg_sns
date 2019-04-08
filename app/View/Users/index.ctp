<?php
    echo $this->Html->css('index_users');
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
                    ),
                    'width' => '150',
                    'height' => '150',
                ));
            ?>
            <div class="name">
                <?php 
                    echo $this->Html->link(
                        h($user['User']['name']),
                        array(
                            'controller' => 'users', 
                            'action' => 'view', 
                            $user['User']['id']
                        )
                    );
                ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
