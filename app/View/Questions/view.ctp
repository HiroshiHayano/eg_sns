<?php
    echo $this->Html->css('index_questions');
    echo $this->element('head', array('title' => '質問'));
    echo $this->element('header');
?>

<div class='container'>
    <div class='row'>
        <nav class='col-md-3'>
            <?php echo $this->element('questions_sidebar'); ?>
        </nav>
        <div class='col-md-9'>
            <div class="page-header">
                <h2>質問</h2>
            </div>
            <!-- <ここに内容> -->
            <?php
                echo $this->element('questions_display', array(
                    'question' => $question,
                    'answers' => $answers,
                    'comments' => $comments,
                    'users_name' => $users_name,
                    'users_image' => $users_image,
                ))
            ?>
            <!-- <ここに内容> -->
        </div>
    </div>
</div>

<div class='container' id='postform_layer'>
    <div class='form-group row'>
        <div class='col-md-2'></div>
        <div class='col-md-8'>
            <?php
                echo $this->Form->create('Knowledge', [
                    'action' => 'add',
                ]);
                echo $this->Form->input('title', [
                    'rows' => 3,
                    'value' => '',
                    'label' => 'title:',
                    'class' => 'form-control',
                ]);
                echo $this->Form->input('content', [
                    'type' => 'textarea',
                    'rows' => 10,
                    'value' => '',
                    'label' => 'content:',
                    'class' => 'form-control',
                ]);
                echo $this->Form->input('user_id', [
                    'type' => 'hidden',
                    'value' => $this->Session->read('Auth.User.id')
                ]);
                echo $this->Form->submit('投稿', [
                    'class' => ['btn', ' btn-default', 'text-center']
                ]);
                echo $this->Form->end();

                echo $this->Form->button('キャンセル', [
                    'type' => 'button',
                    'class' => ['btn', 'btn-default', 'pull-right'],
                    'id' => 'postform_closer'
                ])
            ?>        
        </div>
        <div class='col-md-2'></div>
    </div>
</div>
