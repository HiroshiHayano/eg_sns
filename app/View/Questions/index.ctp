<?php
    echo $this->Html->css('questions_index');
    echo $this->element('head', array('title' => '質問一覧'));
    echo $this->element('header');
?>

<div class='container'>
    <div class='row'>
        <nav class='col-md-3'>
            <div class="page-header">
                <h2>メニュー</h2>
            </div>
            <ul class="nav nav-pills nav-stacked" data-spy="affix" data-offset-top="205">
                <li>
                    <?php
                        echo $this->Form->button('質問を投稿する', [
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
            <div class="page-header">
                <h2>質問</h2>
            </div>
            <?php foreach ($questions as $question): ?>
                <div class='row panel panel-default'>
                    <?php
                        $question_color = 'bg-danger';
                        if ($question['Question']['is_resolved'] === true) {
                            $question_color = 'bg-success';
                        } else {
                            $question_color = 'bg-danger';
                        }
                    ?>
                    <!-- <div class='panel-body'> -->
                    <div class='panel-heading'>
                        <?php 
                            echo $this->Html->link(
                                $this->Text->truncate($question['Question']['title'], $title_len), array(
                                    'controller' => 'Questions',
                                    'action' => 'view',
                                    $question['Question']['id']
                                )
                            );

                        ?>
                    </div>
                    <div class='panel-body <?php echo $question_color;?>'>
                        <?php 
                            echo h($this->Text->truncate(
                                $question['Question']['content'], 
                                $content_len
                            ));
                        ?>
                    </div>
                    <!-- </div> -->
                </div>
            <?php endforeach; ?>
                <?php
                    echo $this->Paginator->numbers(
                        [
                            'before' => $this->Paginator->hasPrev() ? $this->Paginator->first('<<').' | ' : '',
                            'after' => $this->Paginator->hasNext() ? ' | '.$this->Paginator->last('>>') : '',
                        ]
                    );
                ?>
        </div>
    </div>
</div>

<div class='container' id='postform_layer'>
    <div class='form-group row'>
        <div class='col-md-2'></div>
        <div class='col-md-8'>
            <?php
                echo $this->Form->create('Question', [
                    'action' => 'add',
                ]);
                echo $this->Form->input('title', [
                    'rows' => 3,
                    'label' => 'title:',
                    'class' => 'form-control',
                ]);
                echo $this->Form->input('content', [
                    'type' => 'textarea',
                    'rows' => 10,
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
