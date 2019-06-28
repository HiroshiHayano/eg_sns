<?php
    echo $this->element('head', ['title' => '[知識]: ' . h($knowledge['Knowledge']['title'])]);
    echo $this->element('header');
?>

<div class='container'>
    <div class='row'>
        <nav class='col-md-3'>
            <?php echo $this->element('knowledges_sidebar'); ?>
        </nav>
        <div class='col-md-9'>
            <div class="page-header">
                <h2>知識</h2>
            </div>
            <?php
                echo $this->element('knowledge_view', array(
                    'knowledge' => $knowledge,
                    'comments' => $comments,
                    'users_name' => $users_name,
                    'users_image' => $users_image,
                    'bookmarks' => $bookmarks,
                ))
            ?>
        </div>
    </div>
</div>
<?=$this->element('footer');?>
