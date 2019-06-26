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
            投稿者：<strong><?php echo h($knowledge['PostUser']['name']);?></strong>
            <?php echo h('投稿日時：'.$knowledge['Knowledge']['created']);?>
            <br/>
            <h4>タグ：<?php echo $this->element('knowledge_tag', ['tags' => $knowledge['Tag']]);?></h4>
            <?php echo $this->element('knowledge_bookmark', ['bookmarks' => $bookmarks, 'knowledge' => $knowledge]);?>
        </div>
    </div>
<?php endforeach; ?>
