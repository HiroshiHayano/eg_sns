<?php
    // echo $this->Html->css('index_users');
    echo $this->element('head', array('title' => 'プロフィール編集'));
    echo $this->element('header');
?>

<div class='container'>
    <div class="page-header">
        <h1>プロフィール編集</h1>
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
        <div class='col-md-9'>
            <div class='form-group'>
                <?php
                    echo $this->Form->create('User', [
                        'action' => 'edit'
                    ]);
                    echo $this->Form->input('name', array(
                        'label' => '名前:',
                        'class' => 'form-control',
                        'placeholder' => '例）山田 太郎'
                    ));
                    echo $this->Form->input('phonetic', array(
                        'label' => 'よみがな',
                        'class' => 'form-control',
                        'placeholder' => '例）やまだ たろう'
                    ));
                    echo $this->Form->input('department_id', array(
                        'options' => $departments,
                        'class' => 'form-control',
                        'label' => array('text' => '部署を選択')
                    ));
                    echo $this->Form->input('mail_address', array(
                        'label' => 'メールアドレス:',
                        'class' => 'form-control',
                    ));
                    ?>
                    <div class='form-inline'>
                        <?php
                            echo $this->Form->input('birthday', array(
                                'label' => '誕生日:',
                                'class' => 'form-control',
                                'monthNames' => false,
                                'dateFormat'=>'YMD',
                                'minYear' => date('Y') - 80,
                                'maxYear' => date('Y'),
                            ));
                        ?>
                    </div>
                    <?php
                        echo $this->Form->input('birthplace', array(
                        'label' => '出身:',
                        'class' => 'form-control',
                        'placeholder' => '都道府県名を入力'
                    ));
                    echo $this->Form->input('hobby', array(
                        'type' => 'textarea',
                        'label' => '趣味:',
                        'class' => 'form-control',
                        'placeholder' => '自由記入'
                    ));
                    echo $this->Form->input('trend', array(
                        'type' => 'textarea',
                        'label' => '最近のマイブーム:',
                        'class' => 'form-control',
                        'placeholder' => '自由記入'
                    ));
                    echo $this->Form->input('message', array(
                        'type' => 'textarea',
                        'label' => '目標:',
                        'class' => 'form-control',
                        'placeholder' => '自由記入'
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
