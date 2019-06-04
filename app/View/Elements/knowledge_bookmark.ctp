<?php if (in_array($knowledge['Knowledge']['id'], $bookmarks)) :?>
    <span class='glyphicon glyphicon-star text-danger' id='<?='off_kid_' . $knowledge['Knowledge']['id'];?>'></span>
    <span style="display: none;" class='glyphicon glyphicon-star-empty text-muted' id='<?='on_kid_' . $knowledge['Knowledge']['id'];?>'></span>
<?php else :?>
    <span style="display: none;" class='glyphicon glyphicon-star text-danger' id='<?='off_kid_' . $knowledge['Knowledge']['id'];?>'></span>
    <span class='glyphicon glyphicon-star-empty text-muted' id='<?='on_kid_' . $knowledge['Knowledge']['id'];?>'></span>
<?php endif;?>
<script>
// execAjax()はhead.ctpで定義
$('#off_kid_<?=$knowledge['Knowledge']['id'];?>').click(function() {
    $('#on_kid_<?=$knowledge['Knowledge']['id'];?>').toggle();
    $('#off_kid_<?=$knowledge['Knowledge']['id'];?>').toggle();
    var url = "<?=$this->Html->url(['controller' => 'bookmarks', 'action' => 'delete']);?>";
    var user_id = "<?=$this->Session->read('Auth.User.id');?>";
    var knowledge_id = "<?=$knowledge['Knowledge']['id'];?>";
    execAjax(url, user_id, knowledge_id);
});
$('#on_kid_<?=$knowledge['Knowledge']['id'];?>').click(function() {
    $('#on_kid_<?=$knowledge['Knowledge']['id'];?>').toggle();
    $('#off_kid_<?=$knowledge['Knowledge']['id'];?>').toggle();
    var url = "<?=$this->Html->url(['controller' => 'bookmarks', 'action' => 'add']);?>";
    var user_id = "<?=$this->Session->read('Auth.User.id');?>";
    var knowledge_id = "<?=$knowledge['Knowledge']['id'];?>";
    execAjax(url, user_id, knowledge_id);
});
</script>
<span class='badge'><?php echo $knowledge['Knowledge']['bookmark_count'];?></span>
