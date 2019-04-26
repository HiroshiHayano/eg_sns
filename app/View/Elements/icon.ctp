<?php
    echo $this->Html->image('icon/' . $user_image, array(
        'url' => array(
            'controller' => 'users',
            'action' => 'view',
            $user_id
        ),
        'class' => 'img-rounded',
        'width' => 40,
        'height' => 40,
    )); 
?>