<?php
namespace common\components;

use Yii;
use yii\base\Widget;
use common\models\EmailForm;
use common\models\TTrip;
use yii\helpers\ArrayHelper;

class EmailWidget extends Widget
{
	public $trip = NULL;
	public $pax = 2;
	public $returnUrl = '/web/contact';
	public function run()
    {
        parent::run();
        $this->renderForm();
    }

    public function renderForm(){
    	$emailForm = new EmailForm();
    	$emailForm->trip = $this->trip;
    	$emailForm->pax = $this->pax; 
    	$listTrip = ArrayHelper::map(TTrip::find()->select('id,name')->where(['status'=>TTrip::STATUS_ON])->asArray()->all(), 'id', 'name');
    	echo $this->render('form',[
    		'listTrip'=>$listTrip,
    		'emailForm' => $emailForm,
    		'returnUrl' => $this->returnUrl,
    	]);
    }
}