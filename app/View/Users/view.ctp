<?php
    echo $this->Html->css('view');
    // echo $this->Html->css('skyblue');
?>
<h2>
    <?php 
        if ($login_user['id'] === $user['User']['id']) {
            echo $this->Html->link('編集', array('action'=>'edit', $user['User']['id']));
        }
    ?>
</h2>

<div class="information">
    <?php
        echo $this->Html->image('icon/' . $user['User']['image']);
    ?>

    <div class="name">
        <?php 
            echo h($user['User']['name']); 
        ?>
    </div>
    <div class="name">
        <?php 
            echo h($user['User']['phonetic']); 
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
            <td>目標</td>
            <td>
                <?php
                    echo nl2br(h($user['User']['goal']));
                ?>
            </td>
        </tr>
    </table>
</div>