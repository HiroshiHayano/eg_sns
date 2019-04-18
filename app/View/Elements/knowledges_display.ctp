<?php
    echo $this->Html->css('view');
?>
<div class='container question_edit_layer'>
    <div class='question_edit'>
        <?php
            echo $this->Form->create('Knowledge', array(
                'type' => 'post',
                'url' => array(
                    'controller' => 'knowledges',
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
                'value' => $knowledge['Knowledge']['id']
            ));
            echo $this->Form->submit('更新する');
            echo $this->Form->end();
        ?>
    </div>
    <div class='question_edit_closer'>閉じる</div>
</div>

<div class='knowledge_form'>
    <h2>新規投稿</h2>
    <?php
        echo $this->Form->create('Knowledge', array(
            'type' => 'post',
            'url' => array(
                'controller' => 'knowledges',
                'action' => 'add',
            ),
        ));
        echo $this->Form->input('title', array(
            'placeholder' => 'タイトル',
            'value' => '',
        ));
        echo $this->Form->input('content', array(
            'placeholder' => '本文',
            'value' => '',
        ));
        echo $this->Form->input('user_id', array(
            'type' => 'hidden',
            'value' => $this->Session->read('Auth.User.id')
        ));
        echo $this->Form->submit();
        echo $this->Form->end();                     
    ?>
</div>

<div class='container wrapper knowledge_space'>
    <div class='title'>
        <?php
            echo nl2br(h($knowledge['Knowledge']['title']));
        ?>
    </div>
    <div class='content'>
        <?php
            echo $this->Text->autoLink($knowledge['Knowledge']['content'], array('target' => '_blank'));
        ?>
    </div>
    <div class='knowledge_information'>
        <div class='created'>
            <?php
                echo h('投稿 ' . $knowledge['Knowledge']['created']);
            ?>
        </div>
        <div class='contributor_image'>
            <?php
                echo $this->Html->image('icon/' . $users_image[$knowledge['Knowledge']['user_id']], array(
                    'url' => array(
                        'controller' => 'users',
                        'action' => 'view',
                        $knowledge['Knowledge']['user_id']
                    ),
                    'class' => 'icon'
                )); 
            ?>
        </div>
        <div class='contributor_name'>
                <?php
                    echo $users_name[$knowledge['Knowledge']['user_id']];
                ?>
        </div>
    </div>
    <?php if ($this->Session->read('Auth.User.id') === $knowledge['Knowledge']['user_id']) :?>
        <div class='answer_setting'>
            <div class='answer_edit'>
                <div class='question_edit_opener'>編集する</div>
            </div>
            <div class='answer_delete'>
                <?php
                    echo $this->Form->create('Knowledge', array(
                        'onsubmit' => 'return confirm("この投稿を削除しますか？")',
                        'url' => array(
                            'controller' => 'knowledges',
                            'action' => 'delete',
                        ),
                    ));
                    echo $this->Form->input('id', array(
                        'type' => 'hidden',
                        'value' => $knowledge['Knowledge']['id'],
                    ));
                    echo $this->Form->submit('投稿を削除');
                    echo $this->Form->end();
                ?>
            </div>
        </div>
    <?php endif; ?>
    <div class='comment_opener'>
        <?php
            echo 'コメント' . count($comments) . '件';
        ?>
    </div>
    <div class='comment'>
        <table>
            <?php foreach ($comments as $comment) :?>
                <tr>
                    <td class='comment_icon'>
                        <div class='comment_image'>
                            <?php 
                                echo $this->Html->image('icon/' . $users_image[$comment['KnowledgesComment']['user_id']], array(
                                    'url' => array(
                                        'controller' => 'users',
                                        'action' => 'view',
                                        $comment['KnowledgesComment']['user_id']
                                    ),
                                    'class' => 'icon'
                                )); 
                            ?>
                        </div>
                        <div class='comment_name'>
                            <?php
                                echo $users_name[$comment['KnowledgesComment']['user_id']];
                            ?>
                        </div>
                    </td>
                    <td>
                        <?php echo $comment['KnowledgesComment']['content'] ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <div class='comment_form'>
            <?php
                echo $this->Form->create('KnowledgesComment', array(
                    'type' => 'post',
                    'url' => array(
                        'controller' => 'knowledgesComments',
                        'action' => 'add',
                    ),
                ));
                echo $this->Form->input('content', array(
                    'type' => 'textarea',
                    'placeholder' => 'コメントはこちらへ'          
                ));
                echo $this->Form->input('knowledge_id', array(
                    'type' => 'hidden',
                    'value' => $knowledge['Knowledge']['id']
                ));
                echo $this->Form->input('user_id', array(
                    'type' => 'hidden',
                    'value' => $this->Session->read('Auth.User.id')
                ));
                echo $this->Form->submit();
                echo $this->Form->end(); 
            ?>
        </div>
    </div>
</div>
