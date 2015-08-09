<?php

use yii\widgets\LinkPager;
/* @var $this yii\web\View */
$this->title = 'Доска объявлений';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Доска объявлений</h1>

        <p class="lead">Просматривайте объявления и добавляйте свои</p>

        <p><a class="btn btn-lg btn-success" href="posts/create">Добавить объявление</a></p>
    </div>

    <div class="body-content">
        <div class="row">
            <?php foreach ($posts as $post) { ?>
            <div class="col-lg-4">
                <h2><?= $post->title; ?></h2>

                <p><?= $post->text; ?></p>

                <p><a class="btn btn-default" href="<?='posts/view?id=' . $post->id; ?>">Просмотреть объявление</a></p>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<div style="text-align: center"><?= LinkPager::widget(['pagination' => $pages]); ?></div>


