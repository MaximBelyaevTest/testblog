<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Posts */

$this->title = 'Добавить объявление';
$this->params['breadcrumbs'][] = ['label' => 'Объявления', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'fileForm' => $fileForm,
    ]) ?>

</div>
