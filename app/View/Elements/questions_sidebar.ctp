<div class="page-header">
    <h2>メニュー</h2>
</div>
<ul class="nav nav-pills nav-stacked">
    <li>
        <div class="page-header">
            <h4>検索
                <small>
                    <span class='glyphicon glyphicon-info-sign text-info' data-toggle='tooltip'  data-html='true' title="' '（半角スペース）で繋ぐとOR検索が可能です"></span>
                </small>
            </h4>
        </div>
        <?php
            echo $this->Form->create('Question', [
                'action' => 'index'
            ]);
            echo $this->Form->input('keyword', [
                'label' => '質問を検索:',
                'type' => 'text',
                'placeholder' => '検索ワードを入力してください',
                'class' => 'form-control'
            ]);
            echo $this->Form->input('user_id', [
                'label' => '投稿者を検索:',
                'type' => 'select', 
                'multiple'=> TRUE,
                'options' => $users,
                'class' => 'form-control',
                'id' => 'users'
            ]);
            echo $this->Form->input('status_filter', [
                'label' => '',
                'type' => 'select', 
                'multiple'=> 'checkbox',
                'options' => [0 => '未解決', 1 => '解決'],
                'class' => 'checkbox-inline',
                'default' => [0, 1]
            ]);
            echo $this->Form->submit('Search', [
                'class' => ['btn', 'btn-default', 'btn-block']
            ]);
            echo $this->Form->end();
        ?>
    </li>
    <div class="page-header">
        <h4>新規投稿</h4>
    </div>
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
                'data-toggle' => 'modal',
                'data-target' => '#post-form'
            ]);
        ?>
    </li>
</ul>

<div class="modal fade" id="post-form" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
                    <span class='glyphicon glyphicon-remove'></span>
                </button>
				<h4 class="modal-title">新規投稿</h4>
			</div>
			<div class="modal-body">
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
                        'class' => ['btn', ' btn-info', 'btn-block']
                    ]);
                    echo $this->Form->end();
                ?>
			</div>
		</div>
	</div>
</div>