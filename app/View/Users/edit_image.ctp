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
            <ul class='list-group'>
                <li class='list-group-item'>
                    <?php 
                        echo $this->Html->link('プロフィールの変更', array(
                            'action'=>'edit', 
                            $this->Session->read('Auth.User.id')
                        )); 
                    ?>
                </li>
                <li class='list-group-item'>
                    <?php 
                        echo $this->Html->link('プロフィール画像の変更', array(
                            'action'=>'edit_image', 
                            $this->Session->read('Auth.User.id')
                        )); 
                    ?>
                </li>
                <li class='list-group-item'>
                    <?php 
                        echo $this->Html->link('パスワードの変更', array(
                            'action'=>'edit_password', 
                            $this->Session->read('Auth.User.id')
                        )); 
                    ?>
                </li>
                <li class='list-group-item'>
                    <?php 
                        echo $this->Form->create('User', array(
                            'onsubmit' => 'return confirm("アカウントを削除しますか？")',
                            'url' => array(
                                'controller' => 'users',
                                'action' => 'delete',
                            )
                        ));
                        echo $this->Form->input('id', array(
                            'type' => 'hidden',
                            'value' => $this->Session->read('Auth.User.id'),
                        ));
                        echo $this->Form->input('name', array(
                            'type' => 'hidden',
                            'value' => $this->Session->read('Auth.User.name') . '(退会済み)',
                        ));
                        echo $this->Form->input('is_deleted', array(
                            'type' => 'hidden',
                            'value' => true,
                        ));
                        echo $this->Form->input('image', array(
                            'type' => 'hidden',
                            'value' => 'mark_question.png',
                        ));
                        echo $this->Form->button('アカウントの削除', [
                            'class' => ['btn', 'btn-danger']
                        ]);
                        echo $this->Form->end();
                    ?>
                </li>
            </ul>
        </div>
        <div class='col-md-3'>
            <div class='thumbnail'>
                <?php echo $this->Html->image(
                    'icon/' . $this->Session->read('Auth.User.image')
                    ); 
                ?>
                <div class='caption'>
                    現在のプロフィール画像
                </div>
            </div>
        </div>
        <div class='col-md-6'>
            <?php
                echo $this->Form->create('User', array(
                    'enctype' => 'multipart/form-data'
                ));    
                echo $this->Form->input('image', array(
                    'label' => array('text' => 'プロフィール画像'), 
                    'class' => 'form-control',
                    'type' => 'file'
                ));
                echo $this->Form->button('プロフィール画像の更新', [
                    'class' => ['btn', 'btn-default'],
                ]); 
                echo $this->Form->end();
            ?>
        </div>
    </div>
</div>
