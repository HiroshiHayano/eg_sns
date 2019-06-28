<?php
    echo $this->element('head', array('title' => h($user['User']['name']) . 'さんの回答した質問'));
    echo $this->element('header');
?>

<div class='container'>
    <div class='row'>
        <nav class='col-md-3'>
            <?php echo $this->element('questions_sidebar'); ?>
        </nav>
        <div class='col-md-9'>
            <div class="page-header">
                <h2>
                    <?php echo h($user['User']['name']) . 'さんの回答した質問'; ?>
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
            <?php echo $this->element('answers_display', ['answers' => $answers]); ?>
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
<?=$this->element('footer');?>
