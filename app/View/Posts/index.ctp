<?php
    echo $this->Html->css('index_posts');
    // echo $this->Html->css('skyblue');
?>

<h1>最近の投稿</h1>
<?php
    // echo $login_user['name'] . 'さん こんにちは！';
    // debug($users);
?>
<div class='content_wrapper'>
    <?php foreach ($posts as $post) : ?>
        <div class='post'>
            <div class='contributor'>
                <div class='icon'>
                    <?php
                        $user_id = $post['Post']['user_id'];
                        echo $this->Html->image(
                            'icon/' . $users_image[$user_id], array(
                                'class' => 'icon'
                            )
                        );
                    ?>
                </div>
                <div class='name'>
                    <?php
                        echo h($users_name[$user_id]);
                    ?>
                </div>
            </div>
            <div class="post_body">
                <?php
                    echo h($post['Post']['content']);
                ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>