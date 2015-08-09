<?php
namespace common\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UserUploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'extensions' => 'png, jpg'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'imageFile' => 'Изображение',
        ];
    }

    public function upload()
    {
        if (!is_null($this->imageFile) && $this->validate()) {
            $this->imageFile->saveAs('static/images/users/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
}