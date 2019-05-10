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
            <span class='glyphicon <?php echo $question_icon;?>' data-toggle='tooltip' title=<?php echo $question_state; ?>>
                <strong>
                    <?php
                        echo $this->Html->link(
                            $this->Text->truncate($question['Question']['title'], 20), array(
                                'controller' => 'Questions',
                                'action' => 'view',
                                $question['Question']['id']
                            )
                        );
                    ?>
                </strong>
            </span>
        </div>
        <div class='panel-body <?php echo $question_color;?>'>
            <?php 
                echo h($this->Text->truncate(
                    $question['Question']['content'], 
                    50
                ));
            ?>
        </div>
        <!-- 回答数表示 -->
        <div class='panel-footer'>
            回答
            <span class="badge"><?php echo $question['Question']['answer_count']; ?></span>
        </div>
    </div>
<?php endforeach; ?>

