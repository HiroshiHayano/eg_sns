<?php
    echo $this->element('head', array('title' => '新規登録'));
    echo $this->Session->flash();
?>
<div class='container text-right'>
    <h3>
        <?php 
            echo $this->Html->link('ログイン', array(
                'controller' => 'users',
                'action' => 'login',
            )); 
        ?>
    </h3>
</div>

<div class='container'>
    <div class='row'>
        <div class='col-md-2'></div>
        <div class='col-md-8 well'>
            <div class="page-header">
                <h2>新規登録</h2>
            </div>
            <div class='form-group'>
                <?php $message = h('5MB以上の画像は登録できません<br>できれば縦横の比率1:1の画像でお願いしますm(__)m'); ?>
                <?php
                    echo $this->Form->create('User', array(
                        'enctype' => 'multipart/form-data',
                    ));
                    echo $this->Form->input('mail_address', array(
                        'label' => 'mail address:',
                        'class' => 'form-control',
                    ));
                    echo $this->Form->input('password', array(
                        'label' => 'password:',
                        'class' => 'form-control',
                        'placeholder' => '７文字以上',
                    ));
                    echo $this->Form->input('password_confirm', array(
                        'label' => 'password （確認用）:',
                        'class' => 'form-control',
                        'placeholder' => '同じパスワードを入力',
                        'type' => 'password',
                    ));
                    echo $this->Form->input('name', array(
                        'label' => '名前:',
                        'class' => 'form-control',
                        'placeholder' => '例）山田 太郎'
                    ));
                    echo $this->Form->input('phonetic', array(
                        'label' => 'よみがな:',
                        'class' => 'form-control',
                        'placeholder' => '例）やまだ たろう'
                    ));
                    // echo $this->Form->input('image', array(
                    //     'label' => "プロフィール画像（顔が写ってるもの）: <span class='glyphicon glyphicon-warning-sign text-danger' data-toggle='tooltip'  data-html='true' title=" . $message . "></span>", 
                    //     'class' => 'form-control',
                    //     'type' => 'file'
                    // ));
                    echo $this->Form->input('department_id', array(
                        'options' => $departments,
                        'label' => '部署を選択:',
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
                        'placeholder' => '都道府県名を入力',
                    ));
                    echo $this->Form->button('登録', array(
                        'class' => 'btn btn-default btn-lg'
                    )); 
                    echo $this->Form->end(); 
                ?>
            </div>
        </div>
        <div class='col-md-2'></div>
    </div>
</div>
<?=$this->element('footer');?>
