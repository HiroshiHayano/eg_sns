<?php
    echo $this->Html->css('index_questions');
    echo $this->element('head', array('title' => '質問'));
    echo $this->element('header');
?>

<div class='container'>
    <div class='row'>
        <nav class='col-md-3'>
            <h2>メニュー</h2>
            <ul class="nav nav-pills nav-stacked">
                <li>
                    <?php
                        echo $this->Form->button('新規投稿はこちら', [
                            'type' => 'button',
                            'class' => ['btn', 'btn-default'],
                            'id' => 'postform_opener'
                        ]);
                    ?>
                </li>
                <?php
                    if (!empty($query)) {
                        echo '<li>検索ワード: ' . $query . '<li>';
                    }
                ?>
                <li>
                    <?php
                        echo $this->Form->create(false, [
                            'type' => 'get',
                            'action' => 'index'
                        ]);
                        echo $this->Form->input('query', [
                            'label' => '',
                            'type' => 'text',
                            'placeholder' => '検索ワードを入力してください',
                            'class' => 'form-control'
                        ]);
                        echo $this->Form->submit('Search', [
                            'class' => ['btn', 'btn-default', 'pull-right']
                        ]);
                        echo $this->Form->end();
                    ?>
                </li>
            </ul>
        </nav>
        <div class='col-md-9'>
            <!-- <ここに内容> -->
            <?php
                echo $this->element('questions_display', array(
                    'question' => $question,
                    'answers' => $answers,
                    'comments' => $comments,
                    'users_name' => $users_name,
                    'users_image' => $users_image,
                ))
            ?>
            <!-- <ここに内容> -->
        </div>
    </div>
</div>

<div class='container' id='postform_layer'>
    <div class='form-group row'>
        <div class='col-md-2'></div>
        <div class='col-md-8'>
            <?php
                echo $this->Form->create('Knowledge', [
                    'action' => 'add',
                ]);
                echo $this->Form->input('title', [
                    'rows' => 3,
                    'value' => '',
                    'label' => 'title:',
                    'class' => 'form-control',
                ]);
                echo $this->Form->input('content', [
                    'type' => 'textarea',
                    'rows' => 10,
                    'value' => '',
                    'label' => 'content:',
                    'class' => 'form-control',
                ]);
                echo $this->Form->input('user_id', [
                    'type' => 'hidden',
                    'value' => $this->Session->read('Auth.User.id')
                ]);
                echo $this->Form->submit('投稿', [
                    'class' => ['btn', ' btn-default', 'text-center']
                ]);
                echo $this->Form->end();

                echo $this->Form->button('キャンセル', [
                    'type' => 'button',
                    'class' => ['btn', 'btn-default', 'pull-right'],
                    'id' => 'postform_closer'
                ])
            ?>        
        </div>
        <div class='col-md-2'></div>
    </div>
</div>
