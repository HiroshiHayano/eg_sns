<?php
    echo $this->Html->css('knowledges_index');
    echo $this->element('head', array('title' => '共有知識一覧'));
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
            <?php foreach ($knowledges as $knowledge): ?>
                <div class='row panel panel-default'>
                    <div class='panel-heading'>
                        <?php 
                            echo $this->Html->link(
                                $this->Text->truncate($knowledge['Knowledge']['title'], $title_len), array(
                                    'controller' => 'knowledges',
                                    'action' => 'view',
                                    $knowledge['Knowledge']['id']
                                )
                            );

                        ?>
                    </div>
                    <div class='panel-body'>
                        <?php 
                            echo h($this->Text->truncate(
                                $knowledge['Knowledge']['content'], 
                                $content_len
                            ));
                        ?>
                    </div>
                </div>
            <?php endforeach; ?>
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
