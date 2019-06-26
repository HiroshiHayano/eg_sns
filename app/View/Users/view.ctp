<?php
    echo $this->Html->css('index_users');
    echo $this->element('head', array('title' => '[プロフィール]: ' . $user['User']['name']));
    echo $this->element('header');
?>

<div class='container'>
    <div class="page-header">
        <h1>プロフィール
            <small>
                <?php 
                    if ($this->Session->read('Auth.User.id') === $user['User']['id']) {
                        echo '&#9656;' . $this->Html->link('アカウントの編集', array('action'=>'edit', $user['User']['id']));
                    }
                ?>
            </small>
        </h1>
    </div>
    <div class='row'>
        <div class='col-md-4'>
            <div class='thumbnail'>
                <?= $this->Upload->uploadImage($user, 'User.image', ['style' => 'prof']);?>
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
    <!-- 最近の投稿 -->
    <style>
    .carousel{
        width:100%;  /*サイズ指定*/
        height:90%;
        margin:auto;
    }
    </style>
    <div class='row'>
        <div id="postCarousel" class="carousel slide">
            <ol class="carousel-indicators">
                <li class="active" data-target="#postCarousel" data-slide-to="0"></li>
                <li data-target="#postCarousel" data-slide-to="1"></li>
                <li data-target="#postCarousel" data-slide-to="2"></li>
                <li data-target="#postCarousel" data-slide-to="3"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <div class='col-md-2'></div>
                    <div class='col-md-8'>
                        <div class="page-header">
                            <h3>
                                <strong>最近投稿した質問</strong>
                                <small>
                                    <?php 
                                        $number_of_remaining_questions = (int)($user['User']['question_count'] - count($questions));
                                        if ($number_of_remaining_questions > 0) {
                                            $text = '他の投稿 (' . $number_of_remaining_questions . '件)';
                                            echo $this->Form->create('Question', [
                                                'action' => 'index'
                                            ]);
                                            echo $this->Form->hidden('name', [
                                                'value' => $user['User']['name'],
                                            ]);
                                            echo $this->Form->hidden('status_filter', [
                                                'value' => '0|1',
                                            ]);
                                            echo $this->Form->submit($text, [
                                                'class' => ['btn', 'btn-link', 'btn-small']
                                            ]);
                                            echo $this->Form->end();                            
                                        }
                                    ?>
                                </small>
                            </h3>
                        </div>
                        <?php 
                            echo $this->element('questions_display', [
                                'questions' => $questions,
                            ]); 
                        ?>
                    </div>
                    <div class='col-md-2'></div>
                </div>
                <div class="item">
                    <div class='col-md-2'></div>
                    <div class='col-md-8'>
                        <div class='page-header'>
                            <h3>
                                <strong>最近投稿した知識</strong>
                                <small>
                                    <?php 
                                        $number_of_remaining_knowledges = (int)($user['User']['knowledge_count'] - count($knowledges));
                                        if ($number_of_remaining_knowledges > 0) {
                                            $text = '他の投稿 (' . $number_of_remaining_knowledges . '件)';
                                            echo $this->Form->create('Knowledge', [
                                                'action' => 'index'
                                            ]);
                                            echo $this->Form->hidden('user_id', [
                                                'value' => $user['User']['id'],
                                                'class' => 'form-control'
                                            ]);
                                            // echo $this->Form->hidden('name', [
                                            //     'value' => $user['User']['name'],
                                            //     'class' => 'form-control'
                                            // ]);
                                            echo $this->Form->submit($text, [
                                                'class' => ['btn', 'btn-link', 'btn-small']
                                            ]);
                                            echo $this->Form->end();                            
                                        }
                                    ?>
                                </small>
                            </h3>
                        </div>
                        <?php 
                            echo $this->element('knowledges_display', [
                                'knowledges' => $knowledges
                            ]); 
                        ?>
                    </div>
                    <div class='col-md-2'></div>
                </div>
                <div class="item">
                    <div class='col-md-2'></div>
                    <div class='col-md-8'>
                        <div class='page-header'>
                            <h3>
                                <strong>最近投稿した回答</strong>
                                <small>
                                    <?php 
                                        $number_of_remaining_answers = (int)($user['User']['answer_count'] - count($answers));
                                        if ($number_of_remaining_answers > 0) {
                                            $button_label = '他の回答 (' . $number_of_remaining_answers . '件)';
                                            echo $this->Form->create('Question', [
                                                'url' => [
                                                    'controller' => 'questions',
                                                    'action' => 'answered_questions_view',
                                                    $user['User']['id']
                                                ]
                                            ]);
                                            echo $this->Form->hidden('answered_user_id', [
                                                'value' => $user['User']['id'],
                                                'class' => 'form-control'
                                            ]);
                                            echo $this->Form->submit($button_label, [
                                                'class' => ['btn', 'btn-link', 'btn-small']
                                            ]);
                                            echo $this->Form->end();                            
                                        }
                                    ?>
                                </small>
                            </h3>
                        </div>
                        <?php 
                            echo $this->element('answers_display', [
                                'answers' => $answers
                            ]); 
                        ?>
                    </div>
                    <div class='col-md-2'></div>
                </div>
                <div class="item">
                    <div class='col-md-2'></div>
                    <div class='col-md-8'>
                        <!-- ブックマークした投稿一覧 -->
                        <div class='page-header'>
                            <h3>
                                <strong>ブックマーク</strong>
                                <small>
                                    <?php 
                                        $number_of_remaining_bookmarks = (int)($number_of_bookmark - count($bookmarked_knowledges));
                                        if ($number_of_remaining_bookmarks > 0) {
                                            $button_label = '他のブックマーク (' . $number_of_remaining_bookmarks . '件)';
                                            echo $this->Form->create('Knowledge', [
                                                'url' => [
                                                    'controller' => 'knowledges',
                                                    'action' => 'bookmarked_knowledges_view',
                                                    $user['User']['id']
                                                ]
                                            ]);
                                            echo $this->Form->hidden('bookmarked_user_id', [
                                                'value' => $user['User']['id'],
                                                'class' => 'form-control'
                                            ]);
                                            echo $this->Form->submit($button_label, [
                                                'class' => ['btn', 'btn-link', 'btn-small']
                                            ]);
                                            echo $this->Form->end();                            
                                        }
                                    ?>
                                </small>
                            </h3>
                        </div>
                        <?php 
                            echo $this->element('knowledges_display', [
                                'knowledges' => $bookmarked_knowledges
                            ]); 
                        ?>
                    </div>
                    <div class='col-md-2'></div>
                </div>
            </div>
            <a class="left carousel-control" href="#postCarousel" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">前へ</span>
            </a>
            <a class="right carousel-control" href="#postCarousel" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">次へ</span>
            </a>
        </div>
    </div>
</div>
