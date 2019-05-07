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
            <?php foreach ($questions as $question): ?>
                <div class='row panel panel-default'>
                    <?php
                        $question_color = 'bg-danger';
                        $question_icon = 'glyphicon-question-sign';
                        $question_state = '未解決';
                        if ($question['Question']['is_resolved'] === true) {
                            $question_color = 'bg-success';
                            $question_icon = 'glyphicon-ok-sign';
                            $question_state = '解決済み';
                        }
                    ?>
                    <!-- <div class='panel-body'> -->
                    <div class='panel-heading'>
                        <?php 
                            echo $this->Html->tag('span', '', [
                                'class' => ['glyphicon', $question_icon],
                                'data-toggle' => 'tooltip',
                                'title' => $question_state,
                            ]);
                            echo $this->Html->link(
                                $this->Text->truncate($question['Question']['title'], $title_len), array(
                                    'controller' => 'Questions',
                                    'action' => 'view',
                                    $question['Question']['id']
                                )
                            );

                        ?>
                    </div>
                    <div class='panel-body <?php echo $question_color;?>'>
                        <?php 
                            echo h($this->Text->truncate(
                                $question['Question']['content'], 
                                $content_len
                            ));
                        ?>
                    </div>
                    <!-- </div> -->
                </div>
            <?php endforeach; ?>
                <?php
                    echo $this->Paginator->numbers(
                        [
                            'before' => $this->Paginator->hasPrev() ? $this->Paginator->first('<<').' | ' : '',
                            'after' => $this->Paginator->hasNext() ? ' | '.$this->Paginator->last('>>') : '',
                        ]
                    );
                ?>
        </div>
    </div>
</div>
