<?php
    echo $this->Html->css('view');
    echo $this->element('head', array('title' => 'プロフィール'));
    echo $this->element('header');
?>

<div class='container'>
    <div class="page-header">
        <h1>プロフィール
            <small class='pull-right'>
                <?php 
                    if ($this->Session->read('Auth.User.id') === $user['User']['id']) {
                        echo $this->Html->link('プロフィールの編集', array('action'=>'edit', $user['User']['id']));
                    }
                ?>
            </small>
        </h1>
    </div>
    <div class='row'>
        <div class='col-md-4'>
            <div class='thumbnail'>
                <?php
                    echo $this->Html->image('icon/' . $user['User']['image']);
                ?>
                <div class='caption'>
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
            </div>
        </div>
        <div class='col-md-8'>
            <div class='row'>
                <table class='table'>
                    <tr>
                        <td class='col-md-4'>所属部署</td>
                        <td class='col-md-8'>
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
    </div>
    <div class='row'>
        <div class='col-md-6'>
            <h3>投稿した質問</h3>
            <?php foreach ($questions as $question) : ?>
                <div class='panel panel-default'>
                    <div class='panel-heading'>
                        <?php
                            echo $this->Html->link($question['Question']['title'], [
                                'controller' => 'questions', 
                                'action' => 'view',
                                $question['Question']['id']
                            ]);
                        ?>
                    </div>
                    <div class='panel-body'>
                        <?php
                            echo $this->Text->truncate($question['Question']['content'], 100);
                        ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class='col-md-6'>
            <h3>共有した知識</h3>
            <?php foreach ($knowledges as $knowledge) : ?>
                <div class='panel panel-default'>
                    <div class='panel-heading'>
                        <?php
                            echo $this->Html->link($knowledge['Knowledge']['title'], [
                                'controller' => 'knowledges', 
                                'action' => 'view',
                                $knowledge['Knowledge']['id']
                            ]);
                        ?>
                    </div>
                    <div class='panel-body'>
                        <?php
                            echo $this->Text->truncate($knowledge['Knowledge']['content'], 200);
                        ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
