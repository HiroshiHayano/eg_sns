<?php
    echo $this->Html->css('knowledges_index');
    echo $this->element('head', array('title' => '共有知識一覧'));
    echo $this->element('header');
?>

<div class='container'>
    <div class='row'>
        <nav class='col-md-3'>
            <div class="page-header">
                <h2>メニュー</h2>
            </div>
            <ul class="nav nav-pills nav-stacked">
                <li>
                    <?php
                        echo $this->Form->button('知識を投稿する', [
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
                <h2>共有知識</h2>
            </div>
            <?php foreach ($knowledges as $knowledge): ?>
                <div class='row panel panel-default'>
                    <div class='panel-heading'>
                        <?php 
                            echo $this->Html->link(
                                $this->Text->truncate($knowledge['Knowledge']['title'], $title_len), array(
                                    'controller' => 'knowledges',
                                    'action' => 'view',
                                    $knowledge['Knowledge']['id']
                                )
                            );

                        ?>
                    </div>
                    <div class='panel-body'>
                        <?php 
                            echo h($this->Text->truncate(
                                $knowledge['Knowledge']['content'], 
                                $content_len
                            ));
                        ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php
                echo $this->Paginator->numbers(
                    array (
                        'before' => $this->Paginator->hasPrev() ? $this->Paginator->first('<<').' | ' : '',
                        'after' => $this->Paginator->hasNext() ? ' | '.$this->Paginator->last('>>') : '',
                    )
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
