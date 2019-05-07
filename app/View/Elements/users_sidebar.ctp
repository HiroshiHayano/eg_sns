<div class="page-header">
    <h2>メニュー</h2>
</div>
<ul class="nav nav-pills nav-stacked">
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
