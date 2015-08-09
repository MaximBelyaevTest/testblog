<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if ($model->image) { ?>
    <img src="<?= $model->image; ?>" >
    <?php } ?>

    <?php if (Yii::$app->user->identity && Yii::$app->user->identity->id == $model->id) {?>
    <p>
        <?= Html::a('Заполнить данные', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>
    <?php } ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            'email:email',
            'info'
        ],
    ]) ?>
</div>

<?php if (Yii::$app->user->identity) { ?>
<h3>Оценка профиля</h3>

<?php if (isset($existingRating) && !is_null($existingRating)) { ?>
    <h4> Ваша оценка: <?= $existingRating->value; ?> </h4>
    <h4> Общая оценка: <?= $model->rating; ?> </h4>
<?php } else { ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($voteModel, 'value')->radioList(array(1=>'1', 2=>'2', 3=>'3', 4=>'4', 5=>'5')); ?>

<div class="form-group">
    <?= Html::submitButton('Оценить', ['class' => 'btn btn-primary']) ?>
</div>
    <?php ActiveForm::end(); }?>


    <?php $form = ActiveForm::begin(); ?>

<?= $form->field($commentModel, 'text')->widget(CKEditor::className(), [
    'options' => ['rows' => 3],
    'preset' => 'basic'
]) ?>

<div class="form-group">
    <?= Html::submitButton('Добавить комментарий', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

<h3>Комментарии</h3>

<?php foreach ($model->comments as $comment)  { ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <?= $comment->text ?>
        </div>
        <div class="panel-footer">Автор: <a href="<?='/user/profile?id=' . $comment->author->id; ?>"><?php echo $comment->author->username; ?></a></div>
    </div>
<?php }} ?>

