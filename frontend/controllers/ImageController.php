<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use common\models\TGalery;
use common\models\TTrip;
use yii\web\NotFoundHttpException;
/**
 * Site controller
 */
class ImageController extends Controller
{
    
   public function actionThumbnail($slug){
        $modelGalery = $this->findOneModel($slug);;
        $response = Yii::$app->getResponse();
        return $response->sendFile($modelGalery['thumbnail'],$modelGalery['name'].'.png', [
                //'mimeType' => 'image/jpg',
               //'fileSize' => $modelGalery->size,
                'inline' => true
        ]);
    }
    public function actionGalery($id){
        if (($modelGalery = TGalery::find()->where(['id'=>$id])->asArray()->one()) !== null) {
            $response = Yii::$app->getResponse();
            return $response->sendFile($modelGalery['filename'],$modelGalery['name'].'.png', [
                    //'mimeType' => 'image/jpg',
                   //'fileSize' => $modelGalery['size'],
                    'inline' => true
            ]);   
        }
    }

   protected function findOneModel($slug){
        if (($listProduct = TTrip::find()->where(['slug'=>$slug])->asArray()->one()) !== null) {
            return $listProduct;
        }else{
            throw new NotFoundHttpException('Data Not Found');
        }
   }
}
