<?php

namespace frontend\controllers;

use common\models\UserUploadForm;
use Yii;
use common\models\User;
use common\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Comment;
use app\models\Rating;
use yii\web\UploadedFile;

class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionProfile($id)
    {
        $voteModel = new Rating();
        $commentModel = new Comment();
        if (!is_null(Yii::$app->user->identity))
        {
        $existingRating = Rating::findOne(['author_id' => Yii::$app->user->identity->id, 'profile_id' => $id]);
        }


        if ($voteModel->load(Yii::$app->request->post()))
        {
            $voteModel->profile_id = $id;
            $voteModel->save();
            return $this->redirect('/user/profile?id=' . $id);
        }
        if ($commentModel->load(Yii::$app->request->post()))
        {
            $commentModel->profile_id = $id;
            $commentModel->save();
            return $this->redirect('/user/profile?id=' . $id);
        }
        else
        {
            return $this->render('profile', (!is_null(Yii::$app->user->identity)) ? [
                'model' => $this->findModel($id),
                'commentModel' => $commentModel,
                'voteModel' => $voteModel,
                'existingRating' => $existingRating,
            ]
            : [
                    'model' => $this->findModel($id),
                    'commentModel' => $commentModel,
                    'voteModel' => $voteModel,
                ]
            );
        }
    }

    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['profile', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $uploadForm = new UserUploadForm();
        $model = $this->findModel($id);

        if (Yii::$app->user->identity->id == $model->id)
        {
            if ($model->load(Yii::$app->request->post()) && $model->save() && Yii::$app->request->isPost)

            {
                $uploadForm->imageFile = UploadedFile::getInstance($uploadForm, 'imageFile');
                if ($uploadForm->upload())
                {
                    $oldImage = substr($model->image, 1);
                    if (is_file($oldImage))
                    unlink($oldImage);
                    $model->image = '/static/images/users/' . $uploadForm->imageFile->name;
                    $model->update();
                }
                return $this->redirect(['profile', 'id' => $model->id]);
            }
            else
            {
                return $this->render('update', [
                    'model' => $model,
                    'uploadForm' => $uploadForm,
                ]);
            }
        }
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
