<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Posts */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Объявления', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-view">

    <h1><?= Html::encode($this->title) ?></h1>
    Автор: <a href="<?='/user/profile?id=' . $model->author->id; ?>"><?php echo $model->author->username; ?></a>

</div>

<div class="row">
    <div class="col-xs-6 col-md-3">
    <?php echo $model->text; ?>
    </div>
</div>
<div class="row">
    <div class="col-xs-6 col-md-3">
        <?php foreach ($model->images as $img) { ?>
            <img src="<?php echo $img->path; ?>" >
        <?php } ?>
    </div>
</div>
