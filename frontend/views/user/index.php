<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            'username',
            'image',
            'email:email',
            'created_at',
            [
                'attribute' => '',
                'format' => 'raw',
                'value' => function ($model) {
                    return '<a class="btn btn-success" href="profile?id=' . $model->id . '">Просмотреть профиль</a>';
                },
            ],
        ],
    ]); ?>

</div>
