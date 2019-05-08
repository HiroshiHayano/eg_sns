<?php
    echo $this->element('head', array('title' => 'プロフィール画像の変更'));
    echo $this->element('header');
?>
<div class='container'>
    <div class="page-header">
        <h1>プロフィール画像の変更</h1>
    </div>
    <div class='row'>
        <div class='col-md-3'>
            <?php echo $this->element('edit_sidebar'); ?>
        </div>
        <div class='col-md-3'>
            <div class='thumbnail'>
                <div class='caption text-center'>
                    現在のプロフィール画像
                </div>
                <?php 
                    echo $this->Html->image(
                        'icon/' . $this->Session->read('Auth.User.image')
                    ); 
                ?>
            </div>
        </div>
        <div class='col-md-6'>
            <?php
                echo $this->Form->create('User', array(
                    'enctype' => 'multipart/form-data'
                ));    
                echo $this->Form->input('image', array(
                    'type' => 'file',
                    'label' => array('text' => 'プロフィール画像'), 
                    'class' => 'form-control',
                ));
                echo $this->Form->button('プロフィール画像の更新', [
                    'class' => ['btn', 'btn-default'],
                ]); 
                echo $this->Form->end();
            ?>
        </div>
    </div>
</div>
