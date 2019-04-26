<?php
    echo $this->Html->css('view');
?>
    
<div class='alert alert-info'>
    <h1>
        <strong class='text-info'>
            <?php
                echo nl2br(h($knowledge['Knowledge']['title']));
            ?>
        </strong>
    </h1>
    <p>
        <?php
            echo nl2br($this->Text->autoLink(
                $knowledge['Knowledge']['content'],
                ['target' => '_blank']
            ));
        ?>
    </p>
    <p class='text-right'>
        <?php
            echo h('投稿日時 ' . $knowledge['Knowledge']['created']);
        ?>
    </p>
    <p class='text-right'>
        <?php
            echo $this->element('icon', [
                'user_image' => $users_image[$knowledge['Knowledge']['user_id']],
                'user_id' => $knowledge['Knowledge']['user_id'],
            ]);
            echo $users_name[$knowledge['Knowledge']['user_id']];
        ?>
    </p>
</div>
<!-- 編集・削除  -->
<?php if ($this->Session->read('Auth.User.id') === $knowledge['Knowledge']['user_id']) :?>
    <div class='row'>
        <div class='col-md-8'></div>
        <div class='col-md-2'>
            <?php
                echo $this->Form->button('編集', [
                    'class' => 'btn btn-default',
                    'data-toggle' => 'collapse',
                    'data-target' => '#edit-form',
                ]);
            ?>
        </div>
        <div class='col-md-2'>
            <?php
                echo $this->Form->create('Knowledge', array(
                    'action' => 'delete',
                    'onsubmit' => 'return confirm("この投稿を削除しますか？")',
                ));
                echo $this->Form->input('id', array(
                    'type' => 'hidden',
                    'value' => $knowledge['Knowledge']['id'],
                ));
                echo $this->Form->button('削除', [
                    'class' => 'btn btn-danger',
                ]);
                echo $this->Form->end();
            ?>
        </div>
    </div>
    <div class='form-group row collapse' id='edit-form'>
        <div class='col-md-1'></div>
        <div class='col-md-10'>
            <?php
                echo $this->Form->create('Knowledge', array(
                    'action' => 'edit'
                ));
                echo $this->Form->input('title', array(
                    'label' => 'title:',
                    'rows' => 2,
                    'class' => 'form-control',
                ));
                echo $this->Form->input('content', array(
                    'label' => 'content:',
                    'type' => 'textarea',
                    'rows' => 5,
                    'class' => 'form-control',
                ));
                echo $this->Form->input('id', array(
                    'type' => 'hidden',
                    'value' => $knowledge['Knowledge']['id']
                ));
                echo $this->Form->submit('更新', [
                    'class' => 'btn btn-default pull-right',
                ]);
                echo $this->Form->end();
            ?>
        </div>
        <div class='col-md-1'></div>
    </div>

<?php endif; ?>

<div class='well'>
    <!-- 回答フォーム  -->
    <div class='form-group'>
        <?php
            echo $this->Form->create('KnowledgesComment', array(
                'action' => 'add',
            ));
            echo $this->Form->input('content', array(
                'rows' => 3,
                'placeholder' => 'コメントはこちらへ',
                'class' => 'form-control',
            ));
            echo $this->Form->input('knowledge_id', array(
                'type' => 'hidden',
                'value' => $knowledge['Knowledge']['id']
            ));
            echo $this->Form->input('user_id', array(
                'type' => 'hidden',
                'value' => $this->Session->read('Auth.User.id')
            ));
            echo $this->Form->submit('投稿', [
                'class' => ['btn btn-default pull-right'],
            ]);
            echo $this->Form->end(); 
        ?>
    </div>

    <div class=''>
        <?php
            echo 'コメント ' . count($comments) . '件';
        ?>
    </div>
    <table class='table'>
        <?php foreach ($comments as $comment) :?>
            <tr>
                <td class='col-md-3'>
                    <div class='thumbnail'>
                        <?php
                            echo $this->element('icon', [
                                'user_image' => $users_image[$comment['KnowledgesComment']['user_id']],
                                'user_id' => $comment['KnowledgesComment']['user_id'],
                            ]);
                        ?>
                        <div class='caption text-center'>
                            <?php
                                echo $users_name[$comment['KnowledgesComment']['user_id']];
                            ?>
                        </div>                    
                    </div>
                </td>
                <td class='col-md-9'>
                    <?php
                        echo $this->Text->autoLink(
                            $comment['KnowledgesComment']['content'],
                            ['target' => '_blank']
                        );
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
