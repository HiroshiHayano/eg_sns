<?php
    echo $this->element('head', array('title' => $user['User']['name'] . 'さんの投稿した知識'));
    echo $this->element('header');
?>

<div class='container'>
    <div class='row'>
        <div class='col-md-12'>
            <div class="page-header">
                <h3>
                    <?php echo $user['User']['name'] . 'さんの投稿した知識'; ?>
                    <small class='pull-right'>
                        <?php 
                            echo '&#9656;' . $this->Html->link('プロフィールへ戻る', array(
                                'controller' => 'users', 
                                'action'=>'view', 
                                $user['User']['id']
                            ));
                        ?>
                    </small>
                </h3>
            </div>
            <?php 
                echo $this->element('knowledges_display', [
                    'knowledges' => $knowledges,
                ]); 
            ?>
            <?php echo $this->element('pagination_footer'); ?>
        </div>
    </div>
</div>