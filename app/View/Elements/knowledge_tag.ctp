<?php foreach ($tags as $tag):?>
    <span class='label label-success knowledgesTag-id_<?=$tag['KnowledgesTag']['id'];?>'><?=h($tag['label']);?></span>
<?php endforeach;?>
