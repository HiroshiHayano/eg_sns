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
                'label' => '社員を検索:',
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
    <?php if (!empty($query) | !empty($department_id)) :?>
        <div class='well'>
            <?php
                if (!empty($query)) {
                    echo '<li><strong>検索ワード:</strong> <br>"' . h($query) . '"<li>';
                }
            ?>
            <?php
                if (!empty($department_id)) {
                    echo '<li><strong>選択部署:</strong> <br>"' . h($departments[$department_id]) . '"<li>';
                }
            ?>
            <?php echo '<li class="text-right"> ' . $number_of_users . '件</li>'; ?>
        </div>
    <?php endif; ?>
</ul>
