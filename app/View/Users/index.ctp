<?php
    echo $this->Html->css('index_users');
    echo $this->element('head', array('title' => '社員一覧'));
    echo $this->element('header');
?>

<div class='container'>
    <div class='row'>
        <nav class='col-md-3'>
            <?php echo $this->element('users_sidebar'); ?>
        </nav>
        <div class='col-md-9'>
            <div class="page-header">
                <h2>社員一覧</h2>
            </div>
            <div class='row row-eq-height'>
                <?php foreach ($users as $user) : ?>
                    <div class='col-md-3'>
                        <div class='thumbnail'>
                            <?php 
                                echo $this->Html->image('icon/' . $user['User']['image'], array(
                                    'url' => array(
                                        'controller' => 'users', 
                                        'action' => 'view', 
                                        $user['User']['id']
                                    ),
                                    // 応急処置。画像の登録時にトリミングするようにしたい
                                    'width' => '150',
                                    'height' => 'auto',
                                ));
                            ?>
                            <div class='caption text-center'>
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
                    </div>
                <?php endforeach; ?>
            </div>
            <?php
                echo $this->Paginator->numbers(
                    array (
                        'before' => $this->Paginator->hasPrev() ? $this->Paginator->first('<<').' | ' : '',
                        'after' => $this->Paginator->hasNext() ? ' | '.$this->Paginator->last('>>') : '',
                    )
                );
            ?>
        </div>
    </div>
</div>
