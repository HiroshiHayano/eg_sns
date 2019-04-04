<h1>最近の投稿</h1>
<?php
    echo $login_user['name'] . 'さん こんにちは！';
?>

<?php foreach ($posts as $post) : ?>
<div class='post'>
    <div class="post_body">
        <?php
            echo h($post['Posts']['body']);
        ?>
    </div>
</div>
<?php endforeach; ?>
