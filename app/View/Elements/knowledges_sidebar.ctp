<div class="page-header">
    <h2>メニュー</h2>
</div>
<ul class="nav nav-pills nav-stacked">
    <li>
        <div class="page-header">
            <h4>検索
                <small>
                    <span class='glyphicon glyphicon-info-sign text-info' data-toggle='tooltip'  data-html='true' title="','で繋ぐとOR、'+'でAND検索が可能です"></span>
                </small>
            </h4>
        </div>
        <?php
            echo $this->Form->create('Knowledge', [
                'action' => 'index'
            ]);
            echo $this->Form->input('keyword', [
                'label' => '知識を検索:',
                'type' => 'text',
                'placeholder' => '検索ワードを入力してください',
                'class' => 'form-control'
            ]);
            echo $this->Form->input('name', [
                'label' => '投稿者を検索:',
                'type' => 'text',
                'placeholder' => '投稿者の名前を入力してください',
                'class' => 'form-control'
            ]);
            echo $this->Form->submit('Search', [
                'class' => ['btn', 'btn-default', 'btn-block']
            ]);
            echo $this->Form->end();
        ?>
    </li>
    <li>
        <div class="page-header">
            <h4>新規投稿</h4>
        </div>
        <?php
            echo $this->Form->button('知識を新規投稿', [
                'type' => 'button',
                'class' => ['btn', 'btn-info', 'btn-block'],
                'data-toggle' => 'collapse',
                'data-target' => '#post-form'
            ]);
        ?>
        <div id='post-form' class='collapse'>
            <div class='well'>
                <?php
                    echo $this->Form->create('Knowledge', [
                        'action' => 'add',
                    ]);
                    echo $this->Form->input('title', [
                        'rows' => 3,
                        'label' => 'title:',
                        'class' => 'form-control',
                        'value' => '',
                    ]);
                    echo $this->Form->input('content', [
                        'type' => 'textarea',
                        'rows' => 10,
                        'label' => 'content:',
                        'class' => 'form-control',
                        'value' => '',
                    ]);
                    echo $this->Form->input('user_id', [
                        'type' => 'hidden',
                        'value' => $this->Session->read('Auth.User.id')
                    ]);
                    echo $this->Form->submit('投稿', [
                        'class' => ['btn', ' btn-default']
                    ]);
                    echo $this->Form->end();
                ?>
            </div>
        </div>
    </li>
</ul>
