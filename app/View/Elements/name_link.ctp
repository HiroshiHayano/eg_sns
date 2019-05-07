<?php
    echo $this->Html->link($user_name, [
        'controller' => 'users',
        'action' => 'view',
        $user_id
    ]); 
?>