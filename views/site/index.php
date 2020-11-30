<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $messages array app\models\Messages*/

$this->title = 'PinkCatChat';
?>
<div class="site-index h-100">
    <div class="d-flex flex-row row  w-100 h-100">
        <div class="col-sm-12 col-md-3 w-100 h-100">
        </div>
        <div class="col-sm-12 col-md-6 w-100 h-100">
            <div class="panel panel-default">

                <div class="panel-heading">
                    <h3 class="panel-title">Чат</h3>
                </div>
                <div class="panel-body chat-panel-body">

                    <?php foreach ($messages as $message) { ?>

                        <div class="well well-message <?= ($message->deleted_at) ? 'well-danger' : '' ?>">
                            <div>
                                <strong><?php echo $message->author->username; ?>:</strong>
                                <?php echo $message->message; ?>
                            </div>
                            <?php if (!$message->deleted_at) { ?>
                                <a type="button" href="<?php echo Url::toRoute(['site/delete', 'id' => $message->id]) ?>" class="close" aria-hidden="true">&times;</a>
                            <?php } else {
                                echo '<span class="delete_lable">Удалено</span>';
                            } ?>
                        </div>
                    <?php }  ?>

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


        <div class="col-sm-12 col-md-3 w-100 h-100 h-100">








        </div>

    </div>

</div>