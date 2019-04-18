<?php
    echo $this->Html->css('view');
?>
<div class='container question_edit_layer'>
    <div class='question_edit'>
        <?php
            echo $this->Form->create('Question', array(
                'type' => 'post',
                'url' => array(
                    'controller' => 'questions',
                    'action' => 'edit'
                )
            ));
            echo $this->Form->input('title', array(
                'placeholder' => 'タイトル',
            ));
            echo $this->Form->input('content', array(
                'placeholder' => '本文'          
            ));
            echo $this->Form->input('id', array(
                'type' => 'hidden',
                'value' => $question['Question']['id']
            ));
            echo $this->Form->submit('更新する');
            echo $this->Form->end();
        ?>
    </div>
    <div class='question_edit_closer'>閉じる</div>
</div>

<div class='container wrapper question_space'>
    <div class="not_resloved">
        <!-- <p>自己解決できない悩み（最近の悩み、知りたいこと、こんなツール欲しい、オススメのご飯屋知りたい、etc…）</p> -->
        <?php if (!empty($question)) : ?>
            <div class='title'>
                <?php
                    echo nl2br(h($question['Question']['title']));
                ?>
            </div>
            <div class='content'>
                <?php
                    echo nl2br(h($question['Question']['content']));
                ?>
            </div>
            <div class='question_information'>
                <div class='created'>
                    <?php
                        echo h('投稿 ' . $question['Question']['created']);
                    ?>
                </div>
                <div class='contributor_name'>
                        <?php
                            echo $users_name[$question['Question']['user_id']];
                        ?>
                </div>
                <div class='contributor_image'>
                    <?php
                        echo $this->Html->image('icon/' . $users_image[$question['Question']['user_id']], array(
                            'url' => array(
                                'controller' => 'users',
                                'action' => 'view',
                                $question['Question']['user_id']
                            ),
                            'class' => 'icon'
                        )); 
                    ?>
                </div>
            </div>
            <?php if ($question['Question']['is_resolved'] === false) :?>
                <?php if ($this->Session->read('Auth.User.id') !== $question['Question']['user_id']) :?>
                    <div class='answer_button'>回答する</div>
                    <div class='answer_form'>
                        <?php
                            echo $this->Form->create('Answer', array(
                                'url' => array(
                                    'controller' => 'answers',
                                    'action' => 'add',
                                ),
                            ));
                            echo $this->Form->textarea('content', array(
                                'placeholder' => '回答はこちらへ'          
                            ));
                            echo $this->Form->hidden('question_id', array(
                                'value' => $question['Question']['id']
                            ));
                            echo $this->Form->hidden('user_id', array(
                                'value' => $this->Session->read('Auth.User.id')
                            ));
                            echo $this->Form->submit();
                            echo $this->Form->end(); 
                        ?>
                    </div>
                <?php else : ?>
                    <div class='answer_setting'>
                        <div class='answer_edit'>
                            <div class='question_edit_opener'>編集する</div>
                        </div>
                        <div class='answer_resolve'>
                            <?php
                                echo $this->Form->create('Question', array(
                                    'type' => 'post',
                                    'onsubmit' => 'return confirm("解決済みにしてよろしいですか？")',
                                    'url' => array(
                                        'controller' => 'questions',
                                        'action' => 'resolve',
                                    ),
                                ));
                                echo $this->Form->hidden('id', array(
                                    'value' => $question['Question']['id'],
                                ));
                                echo $this->Form->hidden('is_resolved', array(
                                    'value' => true,
                                ));
                                echo $this->Form->submit('解決した！');
                                echo $this->Form->end();
                            ?>
                        </div>
                        <div class='answer_delete'>
                            <?php
                                echo $this->Form->create('Question', array(
                                    'onsubmit' => 'return confirm("この質問を削除しますか？")',
                                    'url' => array(
                                        'controller' => 'questions',
                                        'action' => 'delete',
                                    ),
                                ));
                                echo $this->Form->hidden('id', array(
                                    'value' => $question['Question']['id'],
                                ));
                                echo $this->Form->submit('質問を削除');
                                echo $this->Form->end();
                            ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <div class='answer_information'>
                <?php
                    echo '回答' . count($answers) . '件';
                ?>
            </div>
            <div class='answer_wrapper'>
                <?php foreach ($answers as $answer) :?>
                    <div class='answer'>
                        <div class='answer_content'>
                            <?php 
                                echo $answer['Answer']['content'];
                            ?>
                        </div>
                        <div class='answer_icon'>
                            <div class='created'>
                                <?php
                                    echo h('投稿 ' . $answer['Answer']['created']);
                                ?>
                            </div>
                            <div class='contributor_name'>
                                <?php
                                    echo $users_name[$answer['Answer']['user_id']];
                                ?>
                            </div>
                            <div class='contributor_image'>
                                <?php 
                                    echo $this->Html->image('icon/' . $users_image[$answer['Answer']['user_id']], array(
                                        'url' => array(
                                            'controller' => 'users',
                                            'action' => 'view',
                                            $answer['Answer']['user_id']
                                        ),
                                        'class' => 'icon'
                                    ));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class='comment_opener'>
                        <?php
                            echo 'コメント' . count($comments[$answer['Answer']['id']]) . '件';
                        ?>
                    </div>
                    <div class='comment'>
                        <table>
                            <?php foreach ($comments[$answer['Answer']['id']] as $comment) :?>
                                <tr>
                                    <td class='comment_icon'>
                                        <div class='comment_image'>
                                            <?php 
                                                echo $this->Html->image('icon/' . $users_image[$comment['Comment']['user_id']], array(
                                                    'url' => array(
                                                        'controller' => 'users',
                                                        'action' => 'view',
                                                        $comment['Comment']['user_id']
                                                    ),
                                                    'class' => 'icon'
                                                )); 
                                            ?>
                                        </div>
                                        <div class='comment_name'>
                                            <?php
                                                echo $users_name[$comment['Comment']['user_id']];
                                            ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php echo $comment['Comment']['content'] ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                        <?php if ($question['Question']['is_resolved'] === false) :?>
                            <div class='comment_form'>
                                <?php
                                    echo $this->Form->create('Comment', array(
                                        'url' => array(
                                            'controller' => 'comments',
                                            'action' => 'add',
                                        ),
                                    ));
                                    echo $this->Form->textarea('content', array(
                                        'placeholder' => 'コメントはこちらへ'          
                                    ));
                                    echo $this->Form->hidden('answer_id', array(
                                        'value' => $answer['Answer']['id']
                                    ));
                                    echo $this->Form->hidden('user_id', array(
                                        'value' => $this->Session->read('Auth.User.id')
                                    ));
                                    echo $this->Form->submit();
                                    echo $this->Form->end(); 
                                ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach;?>
            </div>
        <?php else : ?>
            <?php if ($this->Session->read('Auth.User.id') === $user['User']['id']) :?>
                <div class='question_form'>
                    <?php
                        echo $this->Form->create('Question', array(
                            'url' => array(
                                'controller' => 'questions',
                                'action' => 'add',
                            ),
                        ));
                        echo $this->Form->textarea('title', array(
                            'placeholder' => 'タイトル'          
                        ));
                        echo $this->Form->textarea('content', array(
                            'placeholder' => '本文'          
                        ));
                        echo $this->Form->hidden('user_id', array(
                            'value' => $this->Session->read('Auth.User.id')
                        ));
                        echo $this->Form->submit();
                        echo $this->Form->end();                     
                    ?>
                </div>
            <?php else : ?>
                <div class='content'>
                    <?php
                        echo h('なし');
                    ?>
                </div>
            <?php endif;?>
        <?php endif; ?>
    </div>
</div>
