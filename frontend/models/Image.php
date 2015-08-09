<?php

namespace app\models;

use Yii;
use frontend\models\Posts;

/**
 * This is the model class for table "image".
 *
 * @property integer $id
 * @property integer $post_id
 * @property string $path
 */
class Image extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'path'], 'required'],
            [['post_id'], 'integer'],
            [['path'], 'string', 'max' => 255],
            [['post_id'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'path' => 'Path',
        ];
    }

    public function getPost()
    {
        return $this->hasOne(Posts::className(), ['id' => 'post_id']);
    }
}
