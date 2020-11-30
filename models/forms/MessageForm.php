<?php

namespace app\models\forms;

use app\models\Message;
use Yii;
use yii\base\Model;

/**
 * This is the model class for table "messages".
 * @property string $message
 */
class MessageForm extends Model
{
    public $messageText;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['messageText'], 'required'],
            [['messageText'], 'string'],
           ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'messageText' => 'Сообщение',
        ];
    }

    public function addMessage()
    {
       
        
        if (!$this->validate()) {
            return null;
        }
        
        $chatMessage = new Message();
        $chatMessage->author_id = Yii::$app->user->id;
        $chatMessage->message = $this->messageText;
        $chatMessage->save();
        return $chatMessage->save() ? $chatMessage : null;

    }
    
}
