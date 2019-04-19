<?php
    echo $this->Html->css('view');
    echo $this->element('head', array('title' => 'プロフィール'));
    echo $this->element('header');
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
        <?php 
            if ($this->Session->read('Auth.User.id') === $user['User']['id']) {
                echo $this->Html->link('プロフィールの編集', array('action'=>'edit', $user['User']['id']));
            }
        ?>
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
<?php
    echo $this->element('questions_display', array(
        'question' => $question,
        'answers' => $answers,
        'comments' => $comments,
        'users_name' => $users_name,
        'users_image' => $users_image,
    ))
?>
