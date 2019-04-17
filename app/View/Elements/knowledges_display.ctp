<?php
    echo $this->Html->css('view');
?>
<div class='knowledge_form'>
    <h2>新規投稿</h2>
    <?php
        echo $this->Form->create('Knowledge', array(
            'url' => array(
                'controller' => 'knowledges',
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

<div class='container wrapper knowledge_space'>
    <div class="not_resloved">
        <div class='title'>
            <?php
                echo nl2br(h($knowledge['Knowledge']['title']));
            ?>
        </div>
        <div class='content'>
            <?php
                echo nl2br(h($knowledge['Knowledge']['content']));
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
                    <div class='knowledge_edit_opener'>編集する</div>
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
                        echo $this->Form->hidden('id', array(
                            'value' => $knowledge['Knowledge']['id'],
                        ));
                        echo $this->Form->submit('投稿を削除');
                        echo $this->Form->end();
                    ?>
                </div>
            </div>
        <?php endif; ?>
            <div class='answer_information'>
                <?php
                    // echo '回答' . count($answers) . '件';
                ?>
            </div>
            <div class='answer_wrapper'>
                <?php foreach ($comments as $comment) :?>
                    <div class='answer'>
                        <div class='answer_content'>
                            <?php 
                                echo $comment['Comment']['content'];
                            ?>
                        </div>
                        <div class='answer_icon'>
                            <div class='created'>
                                <?php
                                    echo h('投稿 ' . $comment['Comment']['created']);
                                ?>
                            </div>
                            <div class='contributor_name'>
                                <?php
                                    echo $users_name[$comment['Comment']['user_id']];
                                ?>
                            </div>
                            <div class='contributor_image'>
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
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
</div>
