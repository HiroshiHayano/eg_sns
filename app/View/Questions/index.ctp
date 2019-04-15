<?php

?>

<div class='container'>
<div class='not_resolved_questions'>
        <?php foreach ($not_resolved_questions as $not_resolved_question): ?>
            <div class='row'>
                <?php 
                    echo $not_resolved_question['Question']['content'];
                    // debug($not_resolved_question);
                ?>
            </div>
        <?php endforeach; ?>
    </div>
    <div class='resolved_questions'>
        <?php foreach ($resolved_questions as $resolved_question): ?>
            <div class='row'>
                <?php 
                    echo $resolved_question['Question']['content'];
                    // debug($not_resolved_question);
                ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
