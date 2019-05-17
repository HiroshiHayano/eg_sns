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
            <h2>
                <?php 
                    echo $this->Html->tag('span', '', [
                        'class' => ['glyphicon', $question_icon],
                        'data-toggle' => 'tooltip',
                        'title' => $question_state,
                    ]);
                ?>
                <strong class='<?php echo $text_color; ?>'>
                    <?php
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
                // echo $this->element('icon', [
                //     'user_image' => $users_image[$question['Question']['user_id']],
                //     'user_id' => $question['Question']['user_id'],
                // ]);
                // echo h($users_name[$question['Question']['user_id']]);
                echo $this->Upload->uploadImage($question['User'], 'User.image', ['style' => 'small']);
                echo h($question['User']['name']);
            ?>
        </p>
    </div>
</div>

<!-- 解決・編集・削除  -->
<?php if ($this->Session->read('Auth.User.id') === $question['Question']['user_id']) :?>
    <div class='row'>
        <div class='col-md-4'>
            <?php
                if ($question['Question']['is_resolved'] === false) {
                    echo $this->Form->create('Question', array(
                        'action' => 'resolve',
                        'onsubmit' => 'return confirm("この投稿を解決済みにしますか？")',
                    ));
                    echo $this->Form->input('id', array(
                        'type' => 'hidden',
                        'value' => $question['Question']['id'],
                    ));
                    echo $this->Form->input('is_resolved', array(
                        'type' => 'hidden',
                        'value' => true,
                    ));
                    echo $this->Form->button('解決', [
                        'class' => 'btn btn-success btn-block',
                    ]);
                    echo $this->Form->end();
                }
            ?>
        </div>
        <div class='col-md-4'>
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
                    'class' => 'btn btn-danger btn-block',
                ]);
                echo $this->Form->end();
            ?>
        </div>
        <div class='col-md-4'>
            <?php
                if ($question['Question']['is_resolved'] === false) {
                    echo $this->Form->button('編集', [
                        'class' => 'btn btn-primary btn-block',
                        'data-toggle' => 'collapse',
                        'data-target' => '#edit-form',
                    ]);    
                }
            ?>
        </div>
    </div>
    <div class='form-group row collapse' id='edit-form'>
        <div class='col-md-1'></div>
        <div class='col-md-10'>
            <div class='panel panel-default'>
                <div class="panel-heading">
                    <h4 class='title'>編集フォーム</h4>
                </div>
                <div class='panel-body bg-primary'>
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
            </div>
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
                    'placeholder' => '回答はこちらへ入力してください',
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

    <div class="page-header">
        <h3>
            <?php
                echo '回答' . $question['Question']['answer_count'] . '件';
            ?>
        </h3>
    </div>
    <div class='panel-group' id='accordion'>
        <?php foreach ($answers as $answer) :?>
            <div class='well'>
                <div class='row'>
                    <div class='col-md-2'>
                        <strong>
                            <?php
                                echo $this->element('name_link', [
                                    'user_name' => $users_name[$answer['Answer']['user_id']],
                                    'user_id' => $answer['Answer']['user_id']
                                ]);
                            ?>
                        </strong>
                    </div>
                    <div class='col-md-10'>
                        <div class='panel panel-default'>
                            <div class='panel-body'>
                                <h4 class='panel-title'>
                                    <?php
                                        echo nl2br($this->Text->autoLink(
                                            $answer['Answer']['content'],
                                            ['target' => '_blank']
                                        ));
                                    ?>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-12'>
                        <div data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $answer['Answer']['id']; ?>">
                            <strong>コメント</strong>
                            <span class="badge"><?php echo $answer['Answer']['comment_count'] ;?></span>
                        </div>
                    </div>
                </div>
                <div id="collapse<?php echo $answer['Answer']['id']; ?>" class="collapse">
                    <div class='panel-collapse'>
                        <?php if ($answer['Answer']['comment_count'] > 0) : ?>
                            <ul class='list-group'>
                                <?php foreach ($comments[$answer['Answer']['id']] as $comment) : ?>
                                    <li class='list-group-item'>
                                        <div class='row'>
                                            <div class='col-md-2'>
                                                <strong>
                                                    <?php
                                                        echo $this->element('name_link', [
                                                            'user_name' => $users_name[$comment['Comment']['user_id']],
                                                            'user_id' => $comment['Comment']['user_id']
                                                        ]);
                                                    ?>
                                                </strong>
                                            </div>
                                            <div class='col-md-10'>
                                                <?php 
                                                    echo nl2br($this->Text->autoLink(
                                                        $comment['Comment']['content'],
                                                        ['target' => '_blank']
                                                    ));
                                                ?>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
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
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
