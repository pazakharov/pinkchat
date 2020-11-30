<?php

use yii\helpers\Url;
?>
<tr>
    <td><?= $model->id ?></td>
    <td><?= $model->username ?></td>
    <td><a type="button" href="<?php echo Url::toRoute(['site/grant-admin-rights', 'id' => $model->id]) ?>" class="close <?= ($model->role == 'admin') ? 'admin_flag' : '' ?>" alt="Восстановить" aria-hidden="true">
            <i class="glyphicon glyphicon-flag" aria-hidden="true"></i><br>
        </a>
    </td>
</tr>