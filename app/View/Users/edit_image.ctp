<?php
    echo $this->element('head', array('title' => 'プロフィール画像の変更'));
    echo $this->element('header');
?>

<h3>
    <?php 
        echo $this->Html->link('プロフィールの変更に戻る', array('action'=>'edit', $this->Session->read('Auth.User.id'))); 
    ?>
</h3>

<h1>現在のプロフィール画像</h1>
<div>
    <div>
        <?php echo $this->Html->image(
            'icon/' . $this->Session->read('Auth.User.image')
            ); 
        ?>
    </div>
    </div>
        <?php
            echo $this->Form->create('User', array(
                'enctype' => 'multipart/form-data'
            ));    
            echo $this->Form->input('image', array(
                'label' => array('text' => 'プロフィール画像'), 
                'type' => 'file'
            ));
            echo $this->Form->button(__('プロフィール画像の更新'), array()); 
            echo $this->Form->end();
        ?>
    </div>
</div>