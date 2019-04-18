<?php
    echo $this->Html->css('index_questions');
    echo $this->element('head', array('title' => '共有知識'));
    echo $this->element('header');
?>

<?php
    echo $this->element('knowledges_display', array(
        'knowledge' => $knowledge,
        'comments' => $comments,
        'users_name' => $users_name,
        'users_image' => $users_image,
    ))
?>