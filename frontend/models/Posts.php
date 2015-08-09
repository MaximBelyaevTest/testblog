<?php

namespace frontend\models;

use Yii;
use yii\web\UploadedFile;
use yii\db\ActiveRecord;
use common\models\User;
use app\models\Image;

/**
 * This is the model class for table "posts".
 *
 * @property integer $id
 * @property string $title
 * @property string $text
 * @property integer $author_id
 */
class Posts extends ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $image;

    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */

    public function rules()
    {
        return [
            [['title', 'text'], 'required'],
            [['text'], 'string'],
            [['author_id'], 'integer'],
            [['title'], 'string', 'max' => 40],
            [['author', 'image'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'text' => 'Текст',
            'author_id' => 'Автор',

        ];
    }

    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    public function getImages()
    {
        return $this->hasMany(Image::className(), ['post_id' => 'id']);
    }

    public function beforeSave($insert)
    {

        $this->author_id = Yii::$app->user->identity->id;

        /**if ($_POST['Posts']['image'])
        {
            if ($this->isNewRecord)
            {
                $this->string = substr(uniqid('image'), 0, 12);
                $this->img = UploadedFile::getInstance($this, 'image');
                $this->filename = 'static/images/posts/' . $this->string . '.' . $this->img->extension;
                $this->img->saveAs($this->filename);
                $this->image = '/' . $this->filename;
            }
            else
            {
                $this->image = UploadedFile::getInstance($this, 'images/posts/');
                if ($this->image)
                {
                    $this->image->saveAs(substr($this->image, 1));
                }
            }
        }**/
        return parent::beforeSave($insert);
    }
}
