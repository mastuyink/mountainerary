<?php

namespace backend\controllers;

use Yii;
use common\models\TTrip;
use common\models\TCategory;
use common\models\TItemType;
use common\models\TGalery;
use common\models\TTripTimeline;
use common\models\TService;
use app\models\TripSearch;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
/**
 * TripController implements the CRUD actions for TTrip model.
 */
class TripController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'add-service' => ['POST'],
                    'follow-up'=> ['POST'],
                ],
            ],
        ];
    }

    public function actionFollowUp($id_trip){
        $model = $this->findModel($id_trip);
        $model->save(false);
        Yii::$app->session->setFlash('success', 'Follow Up Success');
        return $this->redirect(['index']);
    }

    public function actionAddService(){
        $data = Yii::$app->request->post();
        $new = new TService();
        $new->service = $data['service'];
        $new->save(false);
        $result = [
            'value' => $new->id,
            'service' => $new->service,
        ];
        return json_encode($result);
    }

    public function actionAddGalery($id_trip){
        $modelTrip = $this->findModel($id_trip);
        $galerys = TGalery::find()->select('id,name')->where(['id_parent'=>$modelTrip->id])->andWhere(['id_item_type'=>TItemType::TYPE_TRIP])->asArray()->all();
        foreach($galerys as $index => $galery){
           $galeryPreview['preview'][] = ['/galery/galery-view','id'=>$galery['id']];
           $galeryPreview['config'][]  = [
                'caption' => $galery['name'],
                'width'   => "auto",
                'url'     => "/galery/delete-galery?id=".$galery['id'],
                'key'     => $galery['id'],
            ];
        }
        $modelGalery = new TGalery();
        if (Yii::$app->request->isPost) {
            return $this->redirect(['index']);
        }else{
            return $this->render('_form-galery', [
                'modelTrip' => $modelTrip,
                'modelGalery'=>$modelGalery,
                'galeryPreview'=>!empty($galeryPreview) ? $galeryPreview : ['preview'=>['/img/logo.png'],'config'=>['caption'=>'Preview']],
            ]);
        }
    }

    public function actionThumbnail($id)
    {
        $model = $this->findModel($id);
        $response = Yii::$app->getResponse();
        return $response->sendFile($model->thumbnail,'thumbnail.jpg', [
                //'mimeType' => 'image/jpg',
               //'fileSize' => '386',
                'inline' => true
        ]);
    }

    /**
     * Lists all TTrip models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TripSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TTrip model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TTrip model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model          = new TTrip();
        $modelTimelines = [new TTripTimeline()];

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            $model->thumbnailFile = UploadedFile::getInstance($model, 'thumbnailFile');
           try {
                if ($model->thumbnailFile != null) {
               // $model->saveThumbnail($model->slug);
               $basepath = Yii::getAlias('@frontend').'/contentImage/'.$model->idCategory->category.'/'.$model->slug;
                $thumbPath = $basepath.'/thumbnail/';
                FileHelper::createDirectory($thumbPath, $mode = 0777, $recursive = true);
                $model->thumbnail = $thumbPath.$model->thumbnailFile->baseName.'.'.$model->thumbnailFile->extension;
                $model->save(false);
                $model->thumbnailFile->saveAs($thumbPath.$model->thumbnailFile->baseName.'.'.$model->thumbnailFile->extension);

                //$modelGalery->
                }else{
                    $model->save(false);
                }
                foreach ($_POST['TTripTimeline'] as $data) {
                    $modelTimeline             = new TTripTimeline();
                    $modelTimeline->id_trip    = $model->id;
                    $modelTimeline->name       = $data['name'];
                    $modelTimeline->duration   = $data['duration'];
                    $modelTimeline->time_start = $data['time_start'];
                    $modelTimeline->time_end   = $data['time_end'];
                    $modelTimeline->save(false);
                }
               $transaction->commit();
               Yii::$app->session->setFlash('success', 'Create Trip successfull');
           } catch(\Exception $e) {
               $transaction->rollBack();
               Yii::$app->session->setFlash('danger', 'Create Trip Failed');
               throw $e;
           }
            
            return $this->redirect(['index']);
        }

        $listCategory = ArrayHelper::map(TTrip::getCategory(), 'id', 'category');
        $listKeywords = $model->getKeywords();
        $listService     = ArrayHelper::map(TService::find()->orderBy(['service'=>SORT_ASC])->asArray()->all(), 'id', 'service');
        return $this->render('create', [
            'model'        => $model,
            'listCategory' => $listCategory,
            'listKeywords' => $listKeywords,
            'modelTimelines' => $modelTimelines,
            'listService' => $listService,
        ]);
    }

    /**
     * Updates an existing TTrip model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model         = $this->findModel($id);
        $modelTimelines = $model->tripTimelines;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
           $transaction = Yii::$app->db->beginTransaction();
           try {
                $model->setKeywords();
                $model->updateService('includes');
                $model->updateService('excludes');
                $model->thumbnailFile = UploadedFile::getInstance($model, 'thumbnailFile');
                if ($model->thumbnailFile != null) {
                    if (file_exists($model->thumbnail)){
                       unlink($model->thumbnail);
                    }
                     $basepath = Yii::getAlias('@frontend').'/contentImage/'.$model->idCategory->category.'/'.$model->slug;
                     $thumbPath = $basepath.'/thumbnail/';
                     FileHelper::createDirectory($thumbPath, $mode = 0777, $recursive = true);
                     $model->thumbnail = $thumbPath.$model->thumbnailFile->baseName.'.'.$model->thumbnailFile->extension;
                     $model->save(false);
                     $model->thumbnailFile->saveAs($thumbPath.$model->thumbnailFile->baseName.'.'.$model->thumbnailFile->extension);
                }else{
                    $model->save(false);
                }
                foreach ($_POST['TTripTimeline'] as $data) {
                    if (!isset($data['id'])) {
                        $modelTimeline = new TTripTimeline();
                    }else{
                        $modelTimeline = TTripTimeline::findOne($data['id']);
                    }
                    $modelTimeline->id_trip    = $model->id;
                    $modelTimeline->name       = $data['name'];
                    $modelTimeline->duration   = $data['duration'];
                    $modelTimeline->time_start = $data['time_start'];
                    $modelTimeline->time_end   = $data['time_end'];
                    $modelTimeline->save(false);
                    $submitedTimelines[] = $modelTimeline->id;
                }
                if (isset($submitedTimelines)) {
                    $model->updateTimelines($submitedTimelines);
                }
                
                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Update Trip successfull');
           } catch(\Exception $e) {
               $transaction->rollBack();
               Yii::$app->session->setFlash('danger', 'Update Trip Failed');
               throw $e;
           }
            
            return $this->redirect(['index']);
        }

        $listCategory    = ArrayHelper::map(TTrip::getCategory(), 'id', 'category');
        $listKeywords    = $model->getKeywords();
        $model->keywords = ArrayHelper::map($model->usedKeywords, 'idKeyword.keyword', 'idKeyword.keyword');
        $listService     = ArrayHelper::map(TService::find()->orderBy(['service'=>SORT_ASC])->asArray()->all(), 'id', 'service');
        $model->includes = ArrayHelper::map($model->includeServices, 'id_service', 'id_service');
        $model->excludes = ArrayHelper::map($model->excludeServices, 'id_service', 'id_service');
        return $this->render('update', [
            'model'          => $model,
            'listCategory'   => $listCategory,
            'listKeywords'   => $listKeywords,
            'modelTimelines' => empty($modelTimelines) ? [new TTripTimeline()] : $modelTimelines,
            'listService'    => $listService,
        ]);
    }

    /**
     * Deletes an existing TTrip model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $this->findModel($id)->delete();
            $transaction->commit();
            Yii::$app->session->setFlash('success', 'Delete Trip successfull');
        } catch(\Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('danger', 'Delete Trip Failed');
            throw $e;
        }
        

        return $this->redirect(['index']);
    }

    /**
     * Finds the TTrip model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TTrip the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TTrip::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
