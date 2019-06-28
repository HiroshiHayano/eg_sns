<?php foreach ($answers as $answer): ?>
    <div class='panel panel-default'>
        <?php
            $question_color = 'bg-danger';
            $question_icon = 'glyphicon-question-sign';
            $question_state = '未解決';
            if ($answer['Question']['is_resolved'] === true) {
                $question_color = 'bg-success';
                $question_icon = 'glyphicon-ok-sign';
                $question_state = '解決済み';
            }
        ?>
        <div class='panel-heading'>
            <h3>
            <span class='glyphicon <?=$question_icon;?>' data-toggle='tooltip' title=<?=$question_state;?>>
                <strong>
                    <?php 
                        echo $this->Html->link(
                            $this->Text->truncate($answer['Question']['title'], 20), 
                            [
                                'controller' => 'questions',
                                'action' => 'view',
                                $answer['Question']['id']
                            ]
                        );
                    ?>
                </strong>
            </span>
            <small>
                <?php echo h($this->Text->truncate($answer['Question']['content'], 50));?>
            </small>
            </h3>
        </div>
        <div class='panel-body <?=$question_color;?>'>
            <?php echo '回答「' . h($this->Text->truncate($answer['Answer']['content'], 100)) . '」';?>
        </div>
    </div>
<?php endforeach; ?>
