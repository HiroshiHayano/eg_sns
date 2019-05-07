<?php
    echo $this->Html->css('index_questions');
    echo $this->element('head', ['title' => '[共有知識]: ' . $knowledge['Knowledge']['title']]);
    echo $this->element('header');
?>

<div class='container'>
    <div class='row'>
        <nav class='col-md-3'>
            <?php echo $this->element('knowledges_sidebar'); ?>
        </nav>
        <div class='col-md-9'>
            <div class="page-header">
                <h2>共有知識</h2>
            </div>
            <?php
                echo $this->element('knowledge_view', array(
                    'knowledge' => $knowledge,
                    'comments' => $comments,
                    'users_name' => $users_name,
                    'users_image' => $users_image,
                ))
            ?>
        </div>
    </div>
</div>
