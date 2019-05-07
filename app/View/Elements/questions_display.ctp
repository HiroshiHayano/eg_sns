<?php foreach ($questions as $question): ?>
    <div class='panel panel-default'>
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
        <div class='panel-heading'>
            <strong>
                <?php 
                    echo $this->Html->tag('span', '', [
                        'class' => ['glyphicon', $question_icon],
                        'data-toggle' => 'tooltip',
                        'title' => $question_state,
                    ]);
                    echo $this->Html->link(
                        $this->Text->truncate($question['Question']['title'], 20), array(
                            'controller' => 'Questions',
                            'action' => 'view',
                            $question['Question']['id']
                        )
                    );
                ?>
            </strong>
        </div>
        <div class='panel-body <?php echo $question_color;?>'>
            <?php 
                echo h($this->Text->truncate(
                    $question['Question']['content'], 
                    50
                ));
            ?>
        </div>
    </div>
<?php endforeach; ?>

