<div class="page-header">
    <h2>メニュー</h2>
</div>
<ul class="nav nav-pills nav-stacked">
    <li>
        社員の検索ができます
    </li>
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
            echo $this->Form->input('department_id', array(
                'empty' => '(部署を選択してください)',
                'options' => $departments,
                'label' => false,
                'class' => 'form-control',
            ));
            echo $this->Form->submit('Search', [
                'class' => ['btn', 'btn-default', 'btn-block']
            ]);
            echo $this->Form->end();
        ?>
    </li>
    <?php
        if (!empty($query)) {
            echo '<li>検索ワード: "' . h($query) . '"<li>';
        }
    ?>
    <?php
        if (!empty($department_id)) {
            echo '<li>選択部署: "' . h($departments[$department_id]) . '"<li>';
        }
    ?>
</ul>
