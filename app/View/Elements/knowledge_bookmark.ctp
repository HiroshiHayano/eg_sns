<?php if (in_array($knowledge['Knowledge']['id'], $bookmarks)) :?>
    <span class='glyphicon glyphicon-star text-danger <?='off_kid_' . $knowledge['Knowledge']['id'];?>'></span>
    <span style="display: none;" class='glyphicon glyphicon-star-empty text-muted <?='on_kid_' . $knowledge['Knowledge']['id'];?>'></span>
<?php else :?>
    <span style="display: none;" class='glyphicon glyphicon-star text-danger <?='off_kid_' . $knowledge['Knowledge']['id'];?>'></span>
    <span class='glyphicon glyphicon-star-empty text-muted <?='on_kid_' . $knowledge['Knowledge']['id'];?>'></span>
<?php endif;?>
<span class='badge number_of_comments-kid_<?=$knowledge['Knowledge']['id'];?>'><?=$knowledge['Knowledge']['bookmark_count'];?></span>
コメント
<span class='badge'><?=$knowledge['Knowledge']['knowledges_comment_count'];?></span>
<script>
// execAjax()はhead.ctpで定義
$('.off_kid_<?=$knowledge['Knowledge']['id'];?>').click(function() {
    $('.off_kid_<?=$knowledge['Knowledge']['id'];?>').hide();
    $('.on_kid_<?=$knowledge['Knowledge']['id'];?>').show();
    var url = "<?=$this->Html->url(['controller' => 'bookmarks', 'action' => 'delete']);?>";
    var user_id = "<?=$this->Session->read('Auth.User.id');?>";
    var knowledge_id = "<?=$knowledge['Knowledge']['id'];?>";
    execAjax(url, user_id, knowledge_id);
    var number_of_comments = <?=in_array($knowledge['Knowledge']['id'], $bookmarks) ? $knowledge['Knowledge']['bookmark_count'] - 1 : $knowledge['Knowledge']['bookmark_count'];?>;
    $('.number_of_comments-kid_<?=$knowledge['Knowledge']['id'];?>').text(number_of_comments);
});
$('.on_kid_<?=$knowledge['Knowledge']['id'];?>').click(function() {
    $('.off_kid_<?=$knowledge['Knowledge']['id'];?>').show();
    $('.on_kid_<?=$knowledge['Knowledge']['id'];?>').hide();
    var url = "<?=$this->Html->url(['controller' => 'bookmarks', 'action' => 'add']);?>";
    var user_id = "<?=$this->Session->read('Auth.User.id');?>";
    var knowledge_id = "<?=$knowledge['Knowledge']['id'];?>";
    execAjax(url, user_id, knowledge_id);
    var number_of_comments = <?=in_array($knowledge['Knowledge']['id'], $bookmarks) ? $knowledge['Knowledge']['bookmark_count'] : $knowledge['Knowledge']['bookmark_count'] + 1;?>;
    $('.number_of_comments-kid_<?=$knowledge['Knowledge']['id'];?>').text(number_of_comments);
});
</script>
