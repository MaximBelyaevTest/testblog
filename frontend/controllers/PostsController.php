<?php

namespace frontend\controllers;

use common\models\UploadForm;
use Yii;
use frontend\models\Posts;
use frontend\models\PostsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use app\models\Image;

class PostsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'edit'],
                'rules' => [
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['create', 'edit'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
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
        $searchModel = new PostsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Posts();
        $fileForm = new UploadForm();

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            $fileForm->imageFiles = UploadedFile::getInstances($fileForm, 'imageFiles');
            if ($fileForm->upload())
            {
                foreach ($fileForm->imageFiles as $img)
                {
                    $newImage = new Image();
                    $newImage->path = '/static/images/posts/' . $img->name;
                    $newImage->post_id = $model->id;
                    $newImage->save();
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }

        }
        else
        {
            return $this->render('create', [
                'model' => $model,
                'fileForm' => $fileForm,
            ]);
        }
    }

    protected function findModel($id)
    {
        if (($model = Posts::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
