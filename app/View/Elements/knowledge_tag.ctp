<div style="display:inline-flex">
<?php foreach ($tags as $tag):?>
    <?php echo $this->Form->create('Knowledge', ['action' => 'index','style'=>'margin:0']);?>
    <?php echo $this->Form->hidden('tag_id', array(
        'value' => $tag['id'],
        'label' => '',
    ));?>
    <?php echo $this->Form->button(h($tag['label']), [
        'class' => [
            'btn', 
            'btn-success', 
            'btn-sm', 
            'knowledgesTag-id_' . $tag['KnowledgesTag']['id'],
        ],
    ]);?>
    <?php echo $this->Form->end();?>
<?php endforeach;?>
</div>
