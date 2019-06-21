<ul class='list-group'>
    <li class='list-group-item'>
        <?php 
            echo $this->Html->link('プロフィール情報の変更', array(
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
                'action' => 'delete',
            ));
            echo $this->Form->input('id', array(
                'type' => 'hidden',
                'value' => $this->Session->read('Auth.User.id'),
            ));
            echo $this->Form->input('name', array(
                'type' => 'hidden',
                'value' => $this->Session->read('Auth.User.name'),
            ));
            echo $this->Form->input('is_deleted', array(
                'type' => 'hidden',
                'value' => true,
            ));
            echo $this->Form->button('アカウントの削除', [
                'class' => ['btn', 'btn-danger']
            ]);
            echo $this->Form->end();
        ?>
    </li>
</ul>
