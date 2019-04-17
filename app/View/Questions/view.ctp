<?php
    echo $this->Html->css('index_questions');
    echo $this->element('head', array('title' => '質問'));
    echo $this->element('header');
?>

<?php
    echo $this->element('questions_display', array(
        'question' => $question,
        'answers' => $answers,
        'comments' => $comments,
        'users_name' => $users_name,
        'users_image' => $users_image,
    ))
?>