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
                <?= $this->Upload->uploadImage($this->Session->read('Auth.User'), 'User.image', ['style' => 'prof']);?>
            </div>
        </div>
        <div class='col-md-3'>
            <?php $message = h('5MB以上の画像は登録できません<br>できれば縦横の比率1:1の画像でお願いしますm(__)m'); ?>
            <?= $this->Form->create('User', ['type' => 'file']);?>
            <?= $this->Form->input('User.image', [
                    'label' => "プロフィール画像（顔が写ってるもの）: <span class='glyphicon glyphicon-warning-sign text-danger' data-toggle='tooltip'  data-html='true' title=" . $message . "></span>", 
                    'class' => 'form-control',
                    'type' => 'file'
                ]);?>
            <?= $this->Form->button('プロフィール画像の更新', ['class' => ['btn', 'btn-default']]);?> 
            <?= $this->Form->end();?>

            <?= $this->Form->postLink(
                'プロフィール画像の削除', 
                [
                    'action' => 'delete_image', 
                    $this->Session->read('Auth.User.id')
                ],
                ['class' => 'btn btn-danger']
            ); ?>
        </div>

        <!-- サムネイル表示 -->
        <span class='col-md-3' id='thumbnail'>
        </span>
    </div>
</div>
