<?php
namespace common\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $imageFiles;

    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 5],
        ];
    }

    public function attributeLabels()
    {
        return [
            'imageFiles' => 'Изображения',
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            foreach ($this->imageFiles as $file) {
                $filename = 'static/images/posts/' . $file->baseName . '.' . $file->extension;
                $file->saveAs($filename);
            }
            return true;
        } else {
            return false;
        }
    }
}