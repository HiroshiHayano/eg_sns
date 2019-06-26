<?php
    echo $this->Html->css('view');
?>
<script>
function exec_tagAjax(url, knowledges_tags_id) {
    $.ajax({
        url: url,
        async: false,
        type: "POST",
        data: {
            knowledges_tags_id: knowledges_tags_id,
        },
        dataType: 'text',
    })
    .then(
        // 成功時
        function (data, textStatus, jqXHR){
            // console.log('success');
            // result = data;
        },
        // 失敗時
        function (jqXHR, textStatus, errorThrown){
            console.log('fail');
            console.log(textStatus);
            console.log(jqXHR);
            console.log(errorThrown);
        }
    );
};
</script>

<div class='panel panel-default'>
    <div class='panel-heading'>
        <div class='panel-title'>
            <h2>
                <strong>
                    <?php
                        echo nl2br(h($knowledge['Knowledge']['title']));
                    ?>
                </strong>
            </h2>
        </div>
    </div>
    <div class='panel-body'>
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
                echo '投稿日時 ' . $knowledge['Knowledge']['created'];
            ?>
        </p>
        <p class='text-right'>
            <?php
                echo $this->Upload->uploadImage($knowledge['PostUser'], 'User.image', ['style' => 'small']);
                echo h($knowledge['PostUser']['name']);
            ?>
        </p>
    </div>
    <!-- bookmark機能 -->
    <div class="panel-footer">
        <h4>タグ：<?php echo $this->element('knowledge_tag', ['tags' => $knowledge['Tag']]);?></h4>
        <?php echo $this->element('knowledge_bookmark', ['bookmarks' => $bookmarks, 'knowledge' => $knowledge]);?>
    </div>
</div>
<!-- 編集・削除  -->
<?php if ($this->Session->read('Auth.User.id') === $knowledge['Knowledge']['user_id']) :?>
    <div class='row collapse' id='tag-form'>
        <div class='col-md-2'></div>
        <div class='col-md-8'>
            <div class='panel panel-default'>
                <div class='panel-body'>
                    <?php foreach ($knowledge['Tag'] as $tag) :?>
                        <h5>
                            <div class="alert alert-success alert-dismissable fade in">
                                <?php 
                                echo $this->Form->button('&times;', [
                                    'class' => 'close', 
                                    'data-dismiss' => 'alert',
                                    'aria-label' => 'close',
                                    'id' => 'knowledgesTag-id_' . $tag['KnowledgesTag']['id'],
                                ]);
                                ?>
                                <span><?=h($tag['label']);?></span>
                            </div>
                        </h5>
                        <script>
                            $('#knowledgesTag-id_<?=$tag["KnowledgesTag"]["id"];?>').click(function(){
                                var url = "<?=$this->Html->url(['controller' => 'knowledgesTag', 'action' => 'delete']);?>";
                                var knowledges_tags_id = "<?=$tag["KnowledgesTag"]["id"];?>";
                                exec_tagAjax(url, knowledges_tags_id);
                                $('.knowledgesTag-id_<?=$tag['KnowledgesTag']['id']?>').hide();
                            });
                        </script>
                    <?php endforeach;?>
                    <div class='form-group'>
                        <?php 
                            echo $this->Form->create('Tag', [
                                'type' => 'post', 
                                'url' => [
                                    'controller' => 'tags',
                                    'action' => 'add',
                                    $knowledge['Knowledge']['id']
                                ]
                            ]);
                            echo $this->Form->input('label',['label' => '', 'class' => 'form-control']);
                            echo $this->Form->submit('+', ['class' => 'btn btn-default form-inline']);
                            echo $this->Form->end ();                 
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class='col-md-2'></div>
    </div>
    <div class='row'>
        <div class='col-md-4'>
            <?php
                echo $this->Form->button('タグ', [
                    'class' => 'btn btn-success btn-block',
                    'data-toggle' => 'collapse',
                    'data-target' => '#tag-form',
                ]);
            ?>
        </div>
        <div class='col-md-4'>
            <?php
                echo $this->Form->button('編集', [
                    'class' => 'btn btn-primary btn-block',
                    'data-toggle' => 'collapse',
                    'data-target' => '#edit-form',
                ]);
            ?>
        </div>
        <div class='col-md-4'>
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
                    'class' => 'btn btn-danger btn-block',
                ]);
                echo $this->Form->end();
            ?>
        </div>
    </div>
    <div class='form-group row collapse' id='edit-form'>
        <div class='col-md-1'></div>
        <div class='col-md-10'>
            <div class='panel panel-default'>
                <div class="panel-heading">
                    <h4 class='title'>編集フォーム</h4>
                </div>
                <div class='panel-body bg-primary'>
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
                            'class' => 'btn btn-default btn-block',
                        ]);
                        echo $this->Form->end();
                    ?>
                </div>
            </div>
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
                'label' => 'コメント',
                'placeholder' => 'コメントはこちらへ入力してください',
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
                'class' => ['btn', 'btn-default', 'btn-block'],
            ]);
            echo $this->Form->end(); 
        ?>
    </div>

    <div class=''>
        <?php
            echo 'コメント ' . $knowledge['Knowledge']['knowledges_comment_count'] . '件';
        ?>
    </div>
    <table class='table'>
        <?php foreach ($comments as $comment) :?>
            <tr>
                <td class='col-md-3'>
                    <strong>
                        <?php
                            echo $this->element('name_link', [
                                'user_name' => $users_name[$comment['KnowledgesComment']['user_id']],
                                'user_id' => $comment['KnowledgesComment']['user_id']
                            ]);
                        ?>
                    </strong>
                </td>
                <td class='col-md-9'>
                    <?php
                        echo nl2br($this->Text->autoLink(
                            $comment['KnowledgesComment']['content'],
                            ['target' => '_blank']
                        ));
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
