<?php
    // echo $this->Html->css('view');
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
                    <div class='text-center'>
                        <h2>
                            <small>
                                <?php 
                                    echo h($user['User']['phonetic']); 
                                ?>
                            </small>
                        </h2>
                        <h2>
                            <strong>
                                <?php 
                                    echo h($user['User']['name']); 
                                ?>
                            </strong>
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <div class='col-md-8'>
            <div class='row'>
                <table class='table'>
                    <tr>
                        <td class='col-md-4'><strong>所属部署:</strong></td>
                        <td class='col-md-8'>
                            <?php
                                echo $department;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>メールアドレス:</strong></td>
                        <td>
                            <?php
                                echo $user['User']['mail_address'];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>誕生日:</strong></td>
                        <td>
                            <?php
                                echo $user['User']['birthday'];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>出身:</strong></td>
                        <td>
                            <?php
                                echo $user['User']['birthplace'];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>趣味:</strong></td>
                        <td>
                            <?php
                                echo nl2br(h($user['User']['hobby']));
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>最近のマイブーム:</strong></td>
                        <td>
                            <?php
                                echo nl2br(h($user['User']['trend']));
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>一言:</strong></td>
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
                    <strong>質問</strong>
                    <small>
                        <?php 
                            $number_of_remaining_questions = (int)($number_of_questions - count($questions));
                            if ($number_of_remaining_questions > 0) {
                                echo '&#9656;' . $this->Html->link('他の投稿もみる (' . $number_of_remaining_questions . '件)', array(
                                    'controller' => 'questions',
                                    'action'=>'questions_view', 
                                    $user['User']['id']
                                ));
                            }
                        ?>
                    </small>
                </h3>
            </div>
            <?php echo $this->element('questions_display', ['questions' => $questions]); ?>
        </div>
        <div class='col-md-6'>
            <div class='page-header'>
                <h3>
                    <strong>知識</strong>
                    <small>
                        <?php 
                            $number_of_remaining_knowledges = (int)($number_of_knowledges - count($knowledges));
                            if ($number_of_remaining_knowledges > 0) {
                                echo '&#9656;' . $this->Html->link('他の投稿もみる (' . $number_of_remaining_knowledges . '件)', array(
                                    'controller' => 'knowledges',
                                    'action'=>'knowledges_view', 
                                    $user['User']['id']
                                ));
                            }
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
