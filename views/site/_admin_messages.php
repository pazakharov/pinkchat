<?php

use yii\helpers\Url;
?>

<div class="well well-message">
    <div class="">
        <strong>
            <?php echo $model->author->username ?>:
        </strong> <?= $model->message ?>
    </div>
    <a type="button" href="<?php echo Url::toRoute(['site/restore', 'id' => $model->id]) ?>" class="close" alt="Восстановить" aria-hidden="true">
        <i class="glyphicon glyphicon-repeat" aria-hidden="true"></i>
    </a>
</div>