<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use common\models\LoginForm;
use common\models\TTrip;
use common\models\TCurrency;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use common\models\EmailForm;
use common\models\TPages;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
/**
 * Site controller
 */
class WebController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout     = 'main-home';
        $listProduct      = TTrip::find()->joinWith(['idCategory'])->limit(6)->orderBy(['updated_at'=>SORT_DESC])->asArray()->all();
        $session = Yii::$app->session;
        if ($session['currency'] == NULL) {
            $currentCurrency = 'USD';
        }else{
            $currentCurrency = $session['currency'];
        }
        $currency = TCurrency::find()->where(['currency'=>$currentCurrency])->asArray()->one();
        $listTripDropDown = ArrayHelper::map(TTrip::find()->orderBy(['name'=>SORT_ASC])->asArray()->all(), 'id', 'name');
        $homePage = TPages::find()->where(['t_pages.id'=>TPages::HOME_PAGE])->joinWith(['usedKeywords.idKeyword'])->asArray()->one();
        return $this->render('index',[
            'listProduct'      => $listProduct,
            'listTripDropDown' => $listTripDropDown,
            'currency'         => $currency,
            'homePage' => $homePage,
        ]);
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContactUs()
    {
        return $this->render('contact');
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAboutUs()
    {
        $page = TPages::find()->where(['t_pages.id'=>TPages::ABOUT_US])->joinWith(['usedKeywords.idKeyword'])->asArray()->one();
        return $this->render('about',['page'=>$page]);
    }


    // /**
    //  * Requests password reset.
    //  *
    //  * @return mixed
    //  */
    // public function actionRequestPasswordReset()
    // {
    //     $model = new PasswordResetRequestForm();
    //     if ($model->load(Yii::$app->request->post()) && $model->validate()) {
    //         if ($model->sendEmail()) {
    //             Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

    //             return $this->goHome();
    //         } else {
    //             Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
    //         }
    //     }

    //     return $this->render('requestPasswordResetToken', [
    //         'model' => $model,
    //     ]);
    // }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    // public function actionResetPassword($token)
    // {
    //     try {
    //         $model = new ResetPasswordForm($token);
    //     } catch (InvalidParamException $e) {
    //         throw new BadRequestHttpException($e->getMessage());
    //     }

    //     if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
    //         Yii::$app->session->setFlash('success', 'New password saved.');

    //         return $this->goHome();
    //     }

    //     return $this->render('resetPassword', [
    //         'model' => $model,
    //     ]);
    // }
}
