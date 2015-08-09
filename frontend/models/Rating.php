<?php

namespace app\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "rating".
 *
 * @property integer $id
 * @property integer $author_id
 * @property integer $profile_id
 * @property integer $value
 */
class Rating extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rating';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author_id', 'profile_id', 'value'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'Author ID',
            'profile_id' => 'Profile ID',
            'value' => 'Оценка',
        ];
    }

    public function beforeSave($insert)
    {
        $this->author_id = Yii::$app->user->identity->id;
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        $user = User::findOne(['id' => $this->profile_id]);
        $votes = Rating::find()->where(['profile_id' => $this->profile_id])->asArray()->all();
        $summ = 0;
        foreach ($votes as $vote)
        {
            $summ += $vote['value'];
        }
        $user->rating = $summ / count($votes);
        $user->update();
        return parent::afterSave($insert, $changedAttributes);
    }
}
