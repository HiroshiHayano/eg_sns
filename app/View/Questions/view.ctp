<?php
    echo $this->Html->css('index_questions');
    echo $this->element('head', array('title' => '質問'));
    echo $this->element('header');
?>

<div class='container'>
    <div class='row'>
        <nav class='col-md-3'>
            <?php echo $this->element('questions_sidebar'); ?>
        </nav>
        <div class='col-md-9'>
            <div class="page-header">
                <h2>質問</h2>
            </div>
            <!-- <ここに内容> -->
            <?php
                echo $this->element('questions_display', array(
                    'question' => $question,
                    'answers' => $answers,
                    'comments' => $comments,
                    'users_name' => $users_name,
                    'users_image' => $users_image,
                ))
            ?>
            <!-- <ここに内容> -->
        </div>
    </div>
</div>
