<div class="page-header">
    <h2>メニュー</h2>
</div>
<ul class="nav nav-pills nav-stacked">
    <li>
        <?php
            echo $this->Form->create(false, [
                'type' => 'get',
                'action' => 'index'
            ]);
            echo $this->Form->input('query', [
                'label' => '質問を検索:',
                'type' => 'text',
                'placeholder' => '検索ワードを入力してください',
                'class' => 'form-control'
            ]);
            echo $this->Form->submit('Search', [
                'class' => ['btn', 'btn-default', 'btn-block']
            ]);
            echo $this->Form->end();
        ?>
    </li>
    <?php if (!empty($query)) :?>
            <div class='well'>
                <?php
                    if (!empty($query)) {
                        echo '<li><strong>検索ワード:</strong> <br>"' . h($query) . '"<li>';
                    }
                ?>
                <?php echo '<li class="text-right"> ' . $number_of_questions . '件</li>'; ?>
            </div>
    <?php endif; ?>
    <li>
        <?php
            echo $this->Form->button('質問を新規投稿', [
                'type' => 'button',
                'class' => ['btn', 'btn-info', 'btn-block'],
                // 'id' => 'postform_opener'
                'data-toggle' => 'collapse',
                'data-target' => '#post-form'
            ]);
        ?>
        <div id='post-form' class='collapse'>
            <div class='well'>
                <?php
                    echo $this->Form->create('Question', [
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
