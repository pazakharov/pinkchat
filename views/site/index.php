<?php

use app\models\User;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ListView;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $messages array app\models\Messages*/

$this->title = 'PinkCatChat';
?>
<div class="site-index h-100">
    <div class="d-flex flex-row row  w-100 h-100">
        <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->is_admin()) { ?>
            <div class="col-sm-12 col-md-6 w-100 h-100">
                <div role="tabpanel h-100">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Управление Сообщениями</a>
                        </li>
                        <li role="presentation">
                            <a href="#tab" aria-controls="tab" role="tab" data-toggle="tab">Управление Пользователями</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="messages">

                            <?php echo ListView::widget([
                                'dataProvider' => $messagesDataProvider,
                                'itemView' => '_admin_messages.php',
                            ]);
                            ?>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="tab">
                            <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <td>ID</td>
                                        <td>Имя пользователя</td>
                                        <td>Флаг админа</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echo ListView::widget([
                                        'dataProvider' => $usersDataProvider,
                                        'itemView' => '_admin_users.php',
                                    ]);
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="col-sm-12 col-md-6 center-block w-100 h-100">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Чат</h3>
                </div>
                <div class="panel-body chat-panel-body">
                    <?php foreach ($messages as $message) { ?>
                        <div class="well well-message <?= ($message->deleted_at) ? 'well-danger' : '' ?> <?= ($message->author->role === 'admin') ? 'admin-message' : '' ?>">
                            <div>
                                <strong><?php echo $message->author->username; ?>:</strong>
                                <?php echo $message->message; ?>
                            </div>
                            <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->is_admin()) { ?>
                                <?php if (!$message->deleted_at) { ?>
                                    <a type="button" href="<?php echo Url::toRoute(['site/delete', 'id' => $message->id]) ?>" class="close" aria-hidden="true">&times;</a>
                            <?php } else {
                                    echo '<span class="delete_lable">Удалено</span>';
                                }
                            } ?>
                        </div>
                    <?php
                    } ?>
                </div>
                <div class="panel-footer">
                    <?php if (Yii::$app->user->isGuest) { ?>
                        <div class="h4 bold ">Авторизуйтесь чтобы оставлять сообщения</div>
                    <?php } else { ?>
                        <?php $form = ActiveForm::begin(['action' => Url::toRoute('site/add_message')]) ?>

                        <div class="input-group">
                            <?= $form->field($messageModelForm, 'messageText', ['options' => ['tag' => null]])->label(false) ?>

                            <span class="input-group-btn">
                                <?= Html::submitButton('Отправить', ['class' => 'btn btn-default']) ?>
                            </span>
                        </div>
                        <?php ActiveForm::end() ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>