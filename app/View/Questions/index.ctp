<?php
    echo $this->Html->css('index_questions');
    echo $this->element('head', array('title' => '質問一覧'));
    echo $this->element('header');
?>

<div class='container'>
    <h2>共有知識</h2>
    <div class='knowledges row'>
        <?php foreach ($knowledges as $knowledge): ?>
            <div class='question col-md-3'>
                <div class='title'>
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
                <div class='content'>
                    <?php 
                        echo h($this->Text->truncate(
                            $knowledge['Knowledge']['content'], 
                            $content_len
                        ));
                    ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <h2>未解決</h2>
    <div class='not_resolved_questions row'>
        <?php foreach ($not_resolved_questions as $not_resolved_question): ?>
            <div class='question col-md-3'>
                <div class='title'>
                    <?php 
                        echo $this->Html->link(
                            $this->Text->truncate(
                                $not_resolved_question['Question']['title'], 
                                $title_len
                            ), array(
                                'controller' => 'questions',
                                'action' => 'view',
                                $not_resolved_question['Question']['id']
                            )
                        );
                    ?>
                </div>
                <div class='content'>
                    <?php 
                        echo $this->Text->truncate(
                                $not_resolved_question['Question']['content'], 
                                $title_len
                        );
                    ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <h2>解決済み</h2>
    <div class='resolved_questions row'>
        <?php foreach ($resolved_questions as $resolved_question): ?>
            <div class='question col-md-3'>
                <div class='title'>
                    <?php 
                        echo $this->Html->link(
                            $this->Text->truncate(
                                $resolved_question['Question']['title'], 
                                $title_len
                            ), array(
                                'controller' => 'questions',
                                'action' => 'view',
                                $resolved_question['Question']['id']
                            )
                        );
                    ?>
                </div>
                <div class='content'>
                    <?php 
                        echo h($this->Text->truncate(
                            $resolved_question['Question']['content'], 
                            $content_len
                        ));
                    ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
