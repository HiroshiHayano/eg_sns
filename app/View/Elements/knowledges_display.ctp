<?php foreach ($knowledges as $knowledge): ?>
    <div class='panel panel-default'>
        <div class='panel-heading'>
            <strong>
                <?php 
                    echo $this->Html->link(
                        $this->Text->truncate($knowledge['Knowledge']['title'], 50), 
                        [
                            'controller' => 'knowledges',
                            'action' => 'view',
                            $knowledge['Knowledge']['id']
                        ]
                    );

                ?>
            </strong>
        </div>
        <div class='panel-body'>
            <?php 
                echo h($this->Text->truncate(
                    $knowledge['Knowledge']['content'], 
                    100
                ));
            ?>
        </div>
        <div class='panel-footer'>
            <?php echo $this->element('knowledge_bookmark', ['bookmarks' => $bookmarks, 'knowledge' => $knowledge]);?>
            <!-- コメント数表示 -->
            コメント
            <span class='badge'><?php echo $knowledge['Knowledge']['knowledges_comment_count'];?></span>
        </div>
    </div>
<?php endforeach; ?>
