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
            <span class='glyphicon <?=$question_icon;?>' data-toggle='tooltip' title=<?=$question_state;?>>
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
        <div class='panel-body <?=$question_color;?>'>
            <?php 
                echo h($this->Text->truncate(
                    $question['Question']['content'], 
                    100
                ));
            ?>
        </div>
        <!-- 回答数表示 -->
        <div class='panel-footer'>
            投稿者：<strong><?php echo h($question['User']['name']);?></strong>
            <?php echo h('投稿日時：'.$question['Question']['created']);?>
            <br/>
            回答
            <?php $sample_question = empty($question['Answer']) ? '' : 'Answer:'.$question['Answer'][0]['content'];?>
            <span class='badge' data-toggle='tooltip' data-placement='bottom' title=<?php echo h($this->Text->truncate($sample_question, 30));?>>
                <?php echo $question['Question']['answer_count']; ?>
            </span>
        </div>
    </div>
<?php endforeach; ?>
