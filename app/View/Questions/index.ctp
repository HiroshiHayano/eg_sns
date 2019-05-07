<?php
    echo $this->Html->css('questions_index');
    echo $this->element('head', array('title' => '質問一覧'));
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
                echo $this->element('questions_display', [
                    'questions' => $questions,
                ]); 
            ?>
            <?php echo $this->element('pagination_footer'); ?>
        </div>
    </div>
</div>
