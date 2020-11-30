<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\behaviors\TimestampBehavior;
use yii\debug\models\timeline\DataProvider;

/**
 * This is the model class for table "messages".
 *
 * @property int $id
 * @property string $message
 * @property int $author_id
 * @property int|null $deleted_at
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $author
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    self::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message', 'author_id'], 'required'],
            [['message'], 'string'],
            [['author_id', 'deleted_at', 'created_at', 'updated_at'], 'integer'],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'message' => 'Message',
            'author_id' => 'Author ID',
            'deleted_at' => 'Deleted At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }

    /**
     * @return yii\data\ActiveDataProvider;
     */
    public static function MessagesQuery()
    {
        $query = self::find()->orderBy(['id' => SORT_DESC])->with('author');
        if ((Yii::$app->user->isGuest) || (!Yii::$app->user->isGuest && !Yii::$app->user->identity->is_admin())) {
            $query->andFilterWhere(['is', 'deleted_at', new \yii\db\Expression('null')]);
        }
        return $query;
    }

    public function delete()
    {
        $this->deleted_at = time();
        return $this->save();
    }
}
