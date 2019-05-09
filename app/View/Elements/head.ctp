<head>
    <title><?php echo h($title); ?></title>
    <?= $this->Html->script('jquery/jquery-3.4.0.min.js'); ?>
    <?= $this->Html->script('bootstrap/bootstrap.min.js'); ?>
    <?= $this->Html->script('myscript.js') ?>
    <?php echo $this->Html->css('bootstrap/bootstrap'); ?>
    <?php echo $this->Html->css('common'); ?>
    <?php echo $this->html->meta('icon'); ?>
</head>