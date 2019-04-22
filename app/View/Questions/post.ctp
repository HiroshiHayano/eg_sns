<?php
    // echo $this->Html->css('index_questions');
    echo $this->element('head', array('title' => '投稿フォーム'));
    echo $this->element('header');
?>

<div class='container'>
    <div class='row'>
        <div class='col-md-6'>
            <h3>質問<h3>
            <?php
                echo $this->Form->create('Question', [
                    'action' => 'add'
                ]);
                echo $this->Form->input('title');
                echo $this->Form->input('content', [
                    'type' => 'textarea',
                ]);
                echo $this->Form->input('user_id', [
                    'type' => 'hidden',
                    'value' => $this->Session->read('Auth.User.id')
                ]);
                echo $this->Form->submit('投稿');
                echo $this->Form->end();            
            ?>
        </div>
    <!-- </div> -->
    <!-- <div class='row'> -->
        <div class='col-md-6'>
            <h3>知識<h3>
            <?php
                echo $this->Form->create('Knowledge', [
                    'action' => 'add'
                ]);
                echo $this->Form->input('title');
                echo $this->Form->input('content', [
                    'type' => 'textarea',
                ]);
                echo $this->Form->input('user_id', [
                    'type' => 'hidden',
                    'value' => $this->Session->read('Auth.User.id')
                ]);
                echo $this->Form->submit('投稿');
                echo $this->Form->end();            
            ?>
        </div>
    </div>
</div>