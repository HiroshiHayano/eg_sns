<div>
    <h1>
        <?php 
            echo $this->Html->link('プロフィールの変更に戻る', array('action'=>'edit', $this->Session->read('Auth.User.id'))); 
        ?>
    </h1>
</div>

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