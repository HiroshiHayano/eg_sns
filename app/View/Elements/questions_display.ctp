<!-- ここから  -->
<?php
$text_color = 'text-danger';
$question_icon = 'glyphicon-question-sign';
$question_state = '未解決';
if ($question['Question']['is_resolved'] === true) {
    $text_color = 'text-success';
    $question_icon = 'glyphicon-ok-sign';
    $question_state = '解決済み';
}
?>
<div class='panel panel-default'>
    <div class='panel-heading'>
        <div class='panel-title'>
            <h2 class='<?php echo $text_color; ?>'>
                <strong>
                    <?php
                        echo $this->Html->tag('span', '', [
                            'class' => ['glyphicon', $question_icon],
                            'data-toggle' => 'tooltip',
                            'title' => $question_state,
                        ]);                    
                        echo nl2br(h($question['Question']['title']));
                    ?>
                </strong>
            </h2>
        </div>
    </div>
    <div class='panel-body'>
        <p>
            <?php
                echo nl2br($this->Text->autoLink(
                    $question['Question']['content'],
                    ['target' => '_blank']
                ));
            ?>
        </p>
        <p class='text-right'>
            <?php
                echo h('投稿日時 ' . $question['Question']['created']);
            ?>
        </p>
        <p class='text-right'>
            <?php
                echo $this->element('icon', [
                    'user_image' => $users_image[$question['Question']['user_id']],
                    'user_id' => $question['Question']['user_id'],
                ]);
                echo $users_name[$question['Question']['user_id']];
            ?>
        </p>
    </div>
</div>

<!-- 編集・削除  -->
<?php if ($this->Session->read('Auth.User.id') === $question['Question']['user_id']) :?>
    <div class='row'>
        <div class='col-md-8'></div>
        <div class='col-md-2'>
            <?php
                echo $this->Form->button('編集', [
                    'class' => 'btn btn-default',
                    'data-toggle' => 'collapse',
                    'data-target' => '#edit-form',
                ]);
            ?>
        </div>
        <div class='col-md-2'>
            <?php
                echo $this->Form->create('Question', array(
                    'action' => 'delete',
                    'onsubmit' => 'return confirm("この投稿を削除しますか？")',
                ));
                echo $this->Form->input('id', array(
                    'type' => 'hidden',
                    'value' => $question['Question']['id'],
                ));
                echo $this->Form->button('削除', [
                    'class' => 'btn btn-danger',
                ]);
                echo $this->Form->end();
            ?>
        </div>
    </div>
    <div class='form-group row collapse' id='edit-form'>
        <div class='col-md-1'></div>
        <div class='col-md-10'>
            <?php
                echo $this->Form->create('Question', array(
                    'action' => 'edit'
                ));
                echo $this->Form->input('title', array(
                    'label' => 'title:',
                    'rows' => 2,
                    'class' => 'form-control',
                ));
                echo $this->Form->input('content', array(
                    'label' => 'content:',
                    'type' => 'textarea',
                    'rows' => 5,
                    'class' => 'form-control',
                ));
                echo $this->Form->input('id', array(
                    'type' => 'hidden',
                    'value' => $question['Question']['id']
                ));
                echo $this->Form->submit('更新', [
                    'class' => 'btn btn-default btn-block',
                ]);
                echo $this->Form->end();
            ?>
        </div>
        <div class='col-md-1'></div>
    </div>

<?php endif; ?>

<div>
    <!-- 回答フォーム  -->
    <?php if ($question['Question']['is_resolved'] === false) :?>
        <div class='form-group'>
            <?php
                echo $this->Form->create('Answer', array(
                    'action' => 'add',
                ));
                echo $this->Form->input('content', array(
                    'label' => '回答',
                    'rows' => 3,
                    'placeholder' => '回答をこちらへ入力してください',
                    'class' => 'form-control',
                ));
                echo $this->Form->input('question_id', array(
                    'type' => 'hidden',
                    'value' => $question['Question']['id']
                ));
                echo $this->Form->input('user_id', array(
                    'type' => 'hidden',
                    'value' => $this->Session->read('Auth.User.id')
                ));
                echo $this->Form->submit('投稿', [
                    'class' => ['btn btn-default btn-block'],
                ]);
                echo $this->Form->end(); 
            ?>
        </div>
    <?php endif; ?>

    <div>
        <?php
            echo '回答' . count($answers) . '件';
        ?>
    </div>
    <div class='panel-group' id='accordion'>
        <?php foreach ($answers as $answer) :?>
            <div class='well'>
                <div class='row'>
                    <div class='col-md-3'>
                        <div class='thumbnail'>
                            <?php
                                echo $this->element('icon', [
                                    'user_image' => $users_image[$answer['Answer']['user_id']],
                                    'user_id' => $answer['Answer']['user_id'],
                                ]);
                            ?>
                            <div class='caption text-center'>
                                <?php
                                    echo $users_name[$answer['Answer']['user_id']];
                                ?>
                            </div>                    
                        </div>
                    </div>
                    <div class='col-md-9 panel panel-default'>
                        <div class='panel-body'>
                            <h4 class='panel-title'>
                                <!-- <div data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $answer['Answer']['id']; ?>"> -->
                                    <?php
                                        echo $this->Text->autoLink(
                                            $answer['Answer']['content'],
                                            ['target' => '_blank']
                                        );
                                    ?>
                                <!-- </div> -->
                            </h4>
                        </div>
                    </div>
                    <div data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $answer['Answer']['id']; ?>">
                        <strong>コメント</strong>
                        <span class="badge"><?php echo count($comments[$answer['Answer']['id']]) ;?></span>
                    </div>
                </div>
                <?php if (count($comments[$answer['Answer']['id']]) > 0) : ?>
                    <div id="collapse<?php echo $answer['Answer']['id']; ?>" class="collapse">
                        <div class='panel-collapse'>
                            <ul class='list-group'>
                                <?php foreach ($comments[$answer['Answer']['id']] as $comment) :?>
                                    <li class='list-group-item'>
                                        <div class='row'>
                                            <div class='col-md-3'>
                                                <strong>
                                                    <?php
                                                        echo $users_name[$comment['Comment']['user_id']];
                                                    ?>
                                                </strong>
                                            </div>
                                            <div class='col-md-9'>
                                                <?php 
                                                    echo $this->Text->autoLink(
                                                        nl2br(
                                                            $comment['Comment']['content']
                                                        ), array(
                                                            'target' => '_blank'
                                                        )
                                                    );
                                                ?>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <?php if ($question['Question']['is_resolved'] === false) :?>
                                <div class='form-group'>
                                    <?php
                                        echo $this->Form->create('Comment', array(
                                            'action' => 'add',
                                        ));
                                        echo $this->Form->textarea('content', array(
                                            'label' => 'コメント',
                                            'placeholder' => 'コメントはこちらへ入力してください',
                                            'class' => 'form-control',
                                        ));
                                        echo $this->Form->hidden('answer_id', array(
                                            'value' => $answer['Answer']['id']
                                        ));
                                        echo $this->Form->hidden('user_id', array(
                                            'value' => $this->Session->read('Auth.User.id')
                                        ));
                                        echo $this->Form->submit('投稿', [
                                            'class' => ['btn', 'btn-default', 'btn-block']
                                        ]);
                                        echo $this->Form->end(); 
                                    ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
