<?php
    echo $this->Html->css('view');
    echo $this->element('head', array('title' => 'プロフィール'));
    echo $this->element('header');
?>

<div class='container'>
    <div class="page-header">
        <h1>プロフィール
            <small>
                <?php 
                    if ($this->Session->read('Auth.User.id') === $user['User']['id']) {
                        echo '&#9656;' . $this->Html->link('プロフィールの編集', array('action'=>'edit', $user['User']['id']));
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
        <div class="page-header">
            <h2>最近の投稿</h2>
        </div>
        <div class='col-md-6'>
            <div class="page-header">
                <h3>
                    質問
                    <small>
                        <?php 
                            echo '&#9656;' . $this->Html->link('投稿した質問をみる (' . $number_of_questions . '件)', array(
                                'controller' => 'questions',
                                'action'=>'questions_view', 
                                $user['User']['id']
                            ));
                        ?>
                    </small>
                </h3>
            </div>
            <?php echo $this->element('questions_display', ['questions' => $questions]); ?>
        </div>
        <div class='col-md-6'>
            <div class='page-header'>
                <h3>
                    知識
                    <small>
                        <?php 
                            echo '&#9656;' . $this->Html->link('投稿した知識をみる (' . $number_of_knowledges . '件)', array(
                                'controller' => 'knowledges',
                                'action'=>'knowledges_view', 
                                $user['User']['id']
                            ));
                        ?>
                    </small>
                </h3>
            </div>
            <div>
                <?php foreach ($knowledges as $knowledge) : ?>
                    <div class='panel panel-default'>
                        <div class='panel-heading'>
                            <strong>
                                <?php
                                    echo $this->Html->link($knowledge['Knowledge']['title'], [
                                        'controller' => 'knowledges', 
                                        'action' => 'view',
                                        $knowledge['Knowledge']['id']
                                    ]);
                                ?>
                            </strong>
                        </div>
                        <div class='panel-body'>
                            <?php
                                echo h($this->Text->truncate($knowledge['Knowledge']['content'], 50));
                            ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
