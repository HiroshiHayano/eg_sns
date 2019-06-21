<?php
    echo $this->element('head', array('title' => 'パスワードの変更'));
    echo $this->element('header');
?>

<div class='container'>
    <div class="page-header">
        <h1>パスワードの変更</h1>
    </div>
    <div class='row'>
        <div class='col-md-3'>
            <?php echo $this->element('edit_sidebar'); ?>
        </div>
        <div class='col-md-9'>
            <div class='form-group'>
                <?php
                    echo $this->Form->create('User');
                    echo $this->Form->input('password', array(
                        'label' => array('text' => 'パスワード'),
                        'class' => 'form-control',
                        'placeholder' => '７文字以上',
                    ));
                    echo $this->Form->input('password_confirm', array(
                        'label' => array('text' => 'パスワード(確認用)'),
                        'class' => 'form-control',

                        'placeholder' => '同じパスワードを入力',
                        'type' => 'password',
                    ));
                    echo $this->Form->button('更新', [
                        'class' => ['btn', 'btn-default pull-right']
                    ]); 
                    echo $this->Form->end(); 
                ?>
            </div>
        </div>
    </div>
</div>
