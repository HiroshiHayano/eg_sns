<?php
    echo $this->Html->css('index_questions');
    echo $this->Html->css('bootstrap/bootstrap');
?>

<head>
    ヘッダー
    <
    ページリンク(社員一覧、質問一覧),
    検索,
    >
</head>

<div class='container'>
    <h1>未解決</h1>
    <div class='not_resolved_questions row'>
        <?php foreach ($not_resolved_questions as $not_resolved_question): ?>
            <div class='question col-md-3'>
                <div class='title'>
                    <?php 
                        echo $not_resolved_question['Question']['title'];
                    ?>
                </div>
                <div class='content'>
                    <?php 
                        echo $not_resolved_question['Question']['content'];
                    ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <h1>解決済み</h1>
    <div class='resolved_questions row'>
        <?php foreach ($resolved_questions as $resolved_question): ?>
            <div class='question col-md-3'>
                <div class='title'>
                    <?php 
                        echo h($resolved_question['Question']['title']);
                    ?>
                </div>
                <div class='content'>
                    <?php 
                        echo h($resolved_question['Question']['content']);
                    ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <h1>共有知識</h1>
    <div class='resolved_questions row'>
        <?php foreach ($resolved_questions as $resolved_question): ?>
            <div class='question col-md-3'>
                <div class='title'>
                    <?php 
                        echo $resolved_question['Question']['title'];
                    ?>
                </div>
                <div class='content'>
                    <?php 
                        echo $resolved_question['Question']['content'];
                    ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
