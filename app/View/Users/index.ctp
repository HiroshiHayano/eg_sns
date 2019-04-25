<?php
    // echo $this->Html->css('index_users');
    echo $this->element('head', array('title' => '社員一覧'));
    echo $this->element('header');
?>
<style>
  .affix {
      top: 0;
      width: 100%;
  }
 </style>

<div class='container'>
    <!-- <div class='row'>
        <div class='col-md-9'>
            <h2>社員一覧</h2>
        </div>
    </div> -->
    <div class='row'>
        <nav class='col-md-3'>
            <h2>メニュー</h2>
            <ul class="nav nav-pills nav-stacked" data-spy="affix" data-offset-top="205">
                <li>
                    <?php
                        echo $this->Form->create(false, [
                            'action' => 'index'
                        ]);
                        echo $this->Form->input('', [
                            'type' => 'text',
                            'placeholder' => 'キーワードを入力してください',
                            'class' => 'form-control'
                        ]);
                        echo $this->Form->submit('Search', [
                            'class' => ['btn', 'btn-default', 'pull-right']
                        ]);
                        echo $this->Form->end();
                    ?>
                </li>
            </ul>
        </nav>
        <div class='col-md-9'>
            <?php foreach ($users as $user) : ?>
                <div class='icon col-md-3'>
                    <?php 
                        echo $this->Html->image('icon/' . $user['User']['image'], array(
                            'url' => array(
                                'controller' => 'users', 
                                'action' => 'view', 
                                $user['User']['id']
                            ),
                            'width' => '150',
                            'height' => '150',
                        ));
                    ?>
                    <div class="name">
                        <?php 
                            echo $this->Html->link(
                                h($user['User']['name']),
                                array(
                                    'controller' => 'users', 
                                    'action' => 'view', 
                                    $user['User']['id']
                                )
                            );
                        ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
