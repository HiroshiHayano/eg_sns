<head>
    <title><?php echo h($title); ?></title>
    <?php echo $this->Html->script('jquery/jquery-3.4.0.min.js'); ?>
    <?php echo $this->Html->script('bootstrap/bootstrap.min.js'); ?>
    <?php echo $this->Html->script('myscript.js') ?>
    <?php echo $this->Html->css('bootstrap/bootstrap'); ?>
    <?php echo $this->Html->css('common'); ?>
    <?php echo $this->html->meta('icon'); ?>
    <?php echo $this->Html->script('multiselect/bootstrap-multiselect.js'); ?>
    <?php echo $this->Html->css('multiselect/bootstrap-multiselect'); ?>
    <script>
        function execAjax(url, user_id, knowledge_id) {
            $.ajax({
                url: url,
                async: false,
                type: "POST",
                data: {
                    user_id: user_id,
                    knowledge_id: knowledge_id
                },
                dataType: 'text',
            })
            .then(
                // 成功時
                function (data, textStatus, jqXHR){
                    // console.log('success');
                    // result = data;
                },
                // 失敗時
                function (jqXHR, textStatus, errorThrown){
                    console.log('fail');
                    console.log(textStatus);
                    console.log(jqXHR);
                    console.log(errorThrown);
                }
            );
        };
        $(document).ready(function() {
            // $('#knowledges-tags').multiselect();
            $('#users').multiselect({
                includeSelectAllOption: true,
                buttonWidth: '100%'
            });
        });
    </script>
</head>