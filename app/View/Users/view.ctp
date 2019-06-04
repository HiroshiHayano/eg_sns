<?php
    // echo $this->Html->css('view');
    echo $this->element('head', array('title' => 'プロフィール'));
    echo $this->element('header');
?>

<div class='container'>
    <div class="page-header">
        <h1>プロフィール
            <small>
                <?php 
                    if ($this->Session->read('Auth.User.id') === $user['User']['id']) {
                        echo '&#9656;' . $this->Html->link('プロフィールの編集', array('action'=>'edit', $user['User']['id']));
                    }
                ?>
            </small>
        </h1>
    </div>
    <div class='row'>
        <div class='col-md-4'>
            <div class='thumbnail'>
                <?= $this->Upload->uploadImage($user, 'User.image', ['style' => 'prof']);?>
                <div class='caption'>
                    <div class='text-center'>
                        <h2>
                            <small>
                                <?php 
                                    echo h($user['User']['phonetic']); 
                                ?>
                            </small>
                        </h2>
                        <h2>
                            <strong>
                                <?php 
                                    echo h($user['User']['name']); 
                                ?>
                            </strong>
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <div class='col-md-8'>
            <div class='row'>
                <table class='table'>
                    <tr>
                        <td class='col-md-4'><strong>所属部署:</strong></td>
                        <td class='col-md-8'>
                            <?php
                                echo $department;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>メールアドレス:</strong></td>
                        <td>
                            <?php
                                echo $user['User']['mail_address'];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>誕生日:</strong></td>
                        <td>
                            <?php
                                echo $user['User']['birthday'];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>出身:</strong></td>
                        <td>
                            <?php
                                echo $user['User']['birthplace'];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>趣味:</strong></td>
                        <td>
                            <?php
                                echo nl2br(h($user['User']['hobby']));
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>最近のマイブーム:</strong></td>
                        <td>
                            <?php
                                echo nl2br(h($user['User']['trend']));
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>一言:</strong></td>
                        <td>
                            <?php
                                echo nl2br(h($user['User']['message']));
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class="page-header">
            <h2>最近の投稿</h2>
        </div>
        <div class='col-md-6'>
            <div class="page-header">
                <h3>
                    <strong>質問</strong>
                    <small>
                        <?php 
                            $number_of_remaining_questions = (int)($user['User']['question_count'] - count($user['Question']));
                            if ($number_of_remaining_questions > 0) {
                                echo '&#9656;' . $this->Html->link('他の投稿もみる (' . $number_of_remaining_questions . '件)', array(
                                    'controller' => 'questions',
                                    'action'=>'questions_view', 
                                    $user['User']['id']
                                ));
                            }
                        ?>
                    </small>
                </h3>
            </div>
            <?php foreach ($user['Question'] as $question): ?>
                <div class='panel panel-default'>
                    <?php
                        $question_color = 'bg-danger';
                        $question_icon = 'glyphicon-question-sign';
                        $question_state = '未解決';
                        if ($question['is_resolved'] === true) {
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
                                        $this->Text->truncate($question['title'], 20), array(
                                                'controller' => 'Questions',
                                            'action' => 'view',
                                            $question['id']
                                        )
                                    );
                                ?>
                            </strong>
                        </span>
                    </div>
                    <div class='panel-body <?php echo $question_color;?>'>
                        <?php 
                            echo h($this->Text->truncate(
                                $question['content'], 
                                100
                            ));
                        ?>
                    </div>
                    <!-- 回答数表示 -->
                    <div class='panel-footer'>
                        回答
                        <span class="badge"><?= $question['answer_count']; ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class='col-md-6'>
            <div class='page-header'>
                <h3>
                    <strong>知識</strong>
                    <small>
                        <?php 
                            $number_of_remaining_knowledges = (int)($user['User']['knowledge_count'] - count($user['Knowledge']));
                            if ($number_of_remaining_knowledges > 0) {
                                echo '&#9656;' . $this->Html->link('他の投稿もみる (' . $number_of_remaining_knowledges . '件)', array(
                                    'controller' => 'knowledges',
                                    'action'=>'knowledges_view', 
                                    $user['User']['id']
                                ));
                            }
                        ?>
                    </small>
                </h3>
            </div>
            <?php foreach ($user['Knowledge'] as $knowledge): ?>
                <div class='panel panel-default'>
                    <div class='panel-heading'>
                        <strong>
                            <?php 
                                echo $this->Html->link(
                                    $this->Text->truncate($knowledge['title'], 50), array(
                                        'controller' => 'knowledges',
                                        'action' => 'view',
                                        $knowledge['id']
                                    )
                                );

                            ?>
                        </strong>
                    </div>
                    <div class='panel-body'>
                        <?php 
                            echo h($this->Text->truncate(
                                $knowledge['content'], 
                                100
                            ));
                        ?>
                    </div>
                    <!-- コメント数表示 -->
                    <div class='panel-footer'>
                        コメント
                        <span class="badge"><?php echo $knowledge['knowledges_comment_count'] ;?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
