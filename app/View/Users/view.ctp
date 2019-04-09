<?php
    echo $this->Html->css('view');
    // echo $this->Html->css('skyblue');
?>
<?php 
    if ($login_user['id'] === $user['User']['id']) {
        echo $this->Html->link('編集', array('action'=>'edit', $user['User']['id']));
    }
?>
<div class='wrapper profile'>
    <div class="image">
        <?php
            echo $this->Html->image('icon/' . $user['User']['image']);
        ?>

        <div class="phonetic">
            <?php 
                echo h($user['User']['phonetic']); 
            ?>
        </div>
        <div class="name">
            <?php 
                echo h($user['User']['name']); 
            ?>
        </div>
    </div>

    <div class="information">
        <table>
            <tr>
                <td>所属部署</td>
                <td>
                    <?php
                        echo $department;
                    ?>
                </td>
            </tr>
            <tr>
                <td>mail</td>
                <td>
                    <?php
                        echo $user['User']['mail_address'];
                    ?>
                </td>
            </tr>
            <tr>
                <td>誕生日</td>
                <td>
                    <?php
                        echo $user['User']['birthday'];
                    ?>
                </td>
            </tr>
            <tr>
                <td>出身</td>
                <td>
                    <?php
                        echo $user['User']['birthplace'];
                    ?>
                </td>
            </tr>
            <tr>
                <td>趣味</td>
                <td>
                    <?php
                        echo nl2br(h($user['User']['hobby']));
                    ?>
                </td>
            </tr>
            <tr>
                <td width="150px">最近のマイブーム</td>
                <td>
                    <?php
                        echo nl2br(h($user['User']['trend']));
                    ?>
                </td>
            </tr>
            <tr>
                <td>一言</td>
                <td>
                    <?php
                        echo nl2br(h($user['User']['message']));
                    ?>
                </td>
            </tr>
        </table>
    </div>
</div>

<div class='wrapper problem'>
    <div class="not_resloved">
        <!-- <p>自己解決できない悩み（最近の悩み、知りたいこと、こんなツール欲しい、オススメのご飯屋知りたい、etc…）</p> -->
        <?php if (!empty($problem)) : ?>
            <div class='content'>
                <?php
                    echo nl2br(h($problem['Post']['content']));
                ?>
            </div>
            <div class='answer_form'>
                <?php 
                    echo $this->Form->create('Post');
                    echo $this->Form->input('context', array(
                        'type' => 'textarea',
                    ));
                    echo $this->Form->button(__('投稿'), array()); 
                    echo $this->Form->end();
                ?>
            </div>
            <div class='answer_wrapper'>
                <?php foreach ($answers as $answer) :?>
                    <div class='answer'>
                        <div class='answer_icon'>
                            <?php
                                $sender_id = $answer['Post']['sender_id'];
                                echo $this->Html->image(
                                    'icon/' . $users_image[$sender_id], array(
                                        'class' => 'icon'
                                    )
                                );
                            ?>
                        </div>
                        <div class='answer_content'>
                            <?php 
                                // if (!empty($answer['Post']['receiver_id'])) {
                                //     $receiver_id = $answer['Post']['receiver_id'];
                                //     echo $users_name[$receiver_id] . 'さんへ返信';
                                // }
                            ?>
                            <?php echo $answer['Post']['content']; ?>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        <?php else : ?>
            <div class='content'>
                <?php
                    echo h('なし');
                ?>
            </div>
        <?php endif; ?>
    </div>
    <!-- <div class="resloved"> -->
        <!-- <h3>解決済み</h3> -->
        <?php
            // if (!empty($resolerved_problems)) {
            //     foreach ($resolerved_problems as $rp) :
            //         echo nl2br(h($rp['Post']['content']));
            //     endforeach;
            // } else {
            //     echo h('xxxxxxxx');
            // }
        ?>
    <!-- </div> -->
    </div>
</div>
