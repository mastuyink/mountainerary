<?php

namespace backend\controllers;

use Yii;
use common\models\TGalery;
use common\models\TItemType;
use app\models\GalerySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;

/**
 * GaleryController implements the CRUD actions for TGalery model.
 */
class GaleryController extends Controller
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
                ],
            ],
        ];
    }

    public function actionDelete($id){
        if (($model = $this->findModel($id)) !== null) {
            if(file_exists($model->filename)){
                unlink($model->filename);
            }
           $model->delete();
        }
        return true;
    }

    public function actionView($id){
        $modelGalery = $this->findModel($id);;
        $response = Yii::$app->getResponse();
        return $response->sendFile($modelGalery->filename,$modelGalery->name, [
                //'mimeType' => 'image/jpg',
               'fileSize' => $modelGalery->size,
                'inline' => true
        ]);
    }
    public function actionUpload(){
        if (Yii::$app->request->isAjax) {
            $modelGalery = new TGalery();
           // $counter = count(TGalery::find()->asArray()->all());
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $session         = Yii::$app->session;
                $files           = $_FILES['TGalery'];
                $id_parent       = $_POST['id_parent'];
                $id_type_galery  = $_POST['id_type_galery'];
                $slug            = $_POST['slug'];
                $type_galery_dir = $_POST['type_galery_dir'];
                $basepath        = Yii::getAlias('@frontend').'/contentImage/'.$type_galery_dir.'/'.$slug.'/galery/';
                FileHelper::createDirectory($basepath, $mode = 0777, $recursive = true);
                move_uploaded_file($files['tmp_name']['galeryFiles'][0], $basepath.$files['name']['galeryFiles'][0]);
               // $modelGalery->id           = $counter+1;
                $modelGalery->name         = $files['name']['galeryFiles'][0];
                $modelGalery->filename     = $basepath.$files['name']['galeryFiles'][0];
                $modelGalery->size         = $files['size']['galeryFiles'][0];
                $modelGalery->id_parent    = $id_parent;
                $modelGalery->id_item_type = $id_type_galery;
                $modelGalery->save(false);
                $transaction->commit();
            } catch(\Exception $e) {
                $transaction->rollBack();
                //unlink($basepath.$files['name']['galery'][0]);
                throw $e;
            }
            return true;

        }else{
            return $this->goHome();
        }
    }
    public function actionAdd($modelParent,$id_parent,$itemType,$returnUrl){
        if (Yii::$app->request->isPost) {
            return $this->redirect([$returnUrl]);
        }else{
            $modelTrip = $this->findParentModel($modelParent,$id_parent);
            $galerys = TGalery::find()->select('id,name')->where(['id_parent'=>$modelTrip->id])->andWhere(['id_item_type'=>$itemType])->asArray()->all();
            foreach($galerys as $index => $galery){
               $galeryPreview['preview'][] = ['/galery/view?id='.$galery['id']];
               $galeryPreview['config'][]  = [
                    'caption' => $galery['name'],
                    'width'   => "auto",
                    'url'     => "/galery/delete?id=".$galery['id'],
                    'key'     => $galery['id'],
                ];
            }
            $modelGalery = new TGalery();
            $uploadExtraData = [
                        'id_parent'       => $modelTrip->id,
                        'id_type_galery'  => $itemType,
                        'slug'            => $modelTrip->slug,
                        'type_galery_dir' => $modelTrip->idCategory->category,

                    ];
            return $this->render('_form', [
                'modelTrip' => $modelTrip,
                'modelGalery'=>$modelGalery,
                'uploadExtraData'=>$uploadExtraData,
                'galeryPreview'=>isset($galeryPreview) ? $galeryPreview : ['preview'=>['/img/logo.png'],'config'=>['caption'=>'Preview']],
            ]);
        }
    }
    protected function findParentModel($modelParent,$id_parent){
        if (($model = \common\models\TTrip::findOne($id_parent)) !== null) {
            return $model;
        }else{
            throw new NotFoundHttpException('Parent Model Not Found');
        }
    }
    /**
     * Lists all TGalery models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GalerySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * Creates a new TGalery model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    // public function actionCreate()
    // {
    //     $model = new TGalery();

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     return $this->render('create', [
    //         'model' => $model,
    //     ]);
    // }

    /**
     * Updates an existing TGalery model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TGalery model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionDelete($id)
    // {
    //     $this->findModel($id)->delete();

    //     return $this->redirect(['index']);
    // }

    /**
     * Finds the TGalery model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TGalery the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TGalery::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
