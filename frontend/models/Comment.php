<?php

namespace app\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "comment".
 *
 * @property integer $id
 * @property integer $text
 * @property integer $author_id
 * @property integer $profile_id
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text'], 'required'],
            [['author_id', 'profile_id'], 'integer'],
            [['text'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Комментарий',
            'author_id' => 'Автор',
            'profile_id' => 'Profile ID',
        ];
    }

    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    public function beforeSave($insert)
    {
        $this->author_id = Yii::$app->user->identity->id;
        return parent::beforeSave($insert);
    }
}
