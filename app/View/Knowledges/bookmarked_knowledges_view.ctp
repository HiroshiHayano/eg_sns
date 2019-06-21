<?php
    echo $this->element('head', array('title' => h($user['User']['name']) . 'さんのブックマークした知識'));
    echo $this->element('header');
?>

<div class='container'>
    <div class='row'>
        <nav class='col-md-3'>
            <?php echo $this->element('knowledges_sidebar'); ?>
        </nav>
        <div class='col-md-9'>
            <div class="page-header">
                <h2>
                    <?php echo h($user['User']['name']) . 'さんのブックマークした知識'; ?>
                    <small>
                        <?php echo $this->Paginator->counter(array('format' => "全%count%件")) ?>
                    </small>
                    <small>
                        <?php 
                            echo '&#9656;' . $this->Html->link('プロフィールへ戻る', array(
                                'controller' => 'users', 
                                'action'=>'view', 
                                $user['User']['id']
                            ));
                        ?>
                    </small>
                </h2>
            </div>
            <?php echo $this->element('knowledges_display', ['knowledges' => $bookmarked_knowledges]); ?>
            <?php
                echo $this->Paginator->numbers(
                    array (
                        'before' => $this->Paginator->hasPrev() ? $this->Paginator->first('<<').' | ' : '',
                        'after' => $this->Paginator->hasNext() ? ' | '.$this->Paginator->last('>>') : '',
                    )
                );
            ?>
        </div>
    </div>
</div>
