<?php
namespace common\models;

use Yii;
use yii\base\Model;
use common\models\TTrip;
/**
 * Login form
 */
class EmailForm extends Model
{
	public $trip;
	public $email;
	public $name;
	public $date;
	public $departure_city;
	public $message;
	public $pax;

	public function rules()
    {
        return [
           [['email','trip','name','date','departure_city','message','pax'],'required'],
           [['email'],'email'],
           [['date'],'date','format'=>'php:Y-m-d'],
           [['trip'],'integer'],
           [['pax'],'integer','min'=>1],
           [['message'],'string'],

        ];
    }

    public function sendEmail()
    {
    	$htmlBody = '<h1>Detail</h1><table width="100%">
		 	<thead>
		 		<tr>
		 			<th>Name</th>
		 			<th>Email</th>
		 			<th>Numb Participans</th>
		 		</tr>
		 	</thead>
		 	<tbody>
		 		<tr>
		 			<td>'.$this->name.'</td>
		 			<td>'.$this->email.'</td>
		 			<td>'.$this->pax.' Pax</td>
		 		</tr>
		 	</tbody>
		 </table>
		 <p><b>Message</b><br>'.$this->message.'</p>
		 <p><b></b></p>
		 ';
        return Yii::$app->mailer->compose()
            ->setTo(Yii::$app->params['reservationEmail'])
            ->setFrom($this->email)
            ->setSubject('Email From '.$this->name.' About '.$this->getTrip())
            ->setHtmlBody($htmlBody)
            ->send();
    }

    public function getTrip(){
    	$trip = TTrip::find()->where(['id'=>$this->trip])->asArray()->one();
    	return $trip['name'];
    }
}