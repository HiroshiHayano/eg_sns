<?php
    echo $this->element('head', ['title' => '[質問]: ' . h($question['Question']['title'])]);
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
            <?php
                echo $this->element('question_view', array(
                    'question' => $question,
                    'answers' => $answers,
                    'comments' => $comments,
                    'users_name' => $users_name,
                    'users_image' => $users_image,
                ))
            ?>
        </div>
    </div>
</div>
