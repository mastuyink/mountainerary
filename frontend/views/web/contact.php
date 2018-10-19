<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use common\components\EmailWidget;

$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag([
    'name'    => 'description',
    'content' => 'Discuss your itinerary. Contact us via email or whatsapp to discuss your planning. 24/7 Service',
]);
$this->registerMetaTag([
    'name'    => 'keywords',
    'content' => 'how to go mt bromo, Bromo ijen tour, mount bromo itinerary, mount bromo hotels indonesia, mount bromo volcano, mount bromo from malang, see the sunrise, About Mountainerary, contact us, contact mountainerary',
]);
?>
<div class="row">
	<div class="col-md-12">
		<div class="material-card">
        <div class="material-card_content">
		<?= EmailWidget::widget(); ?>
		</div>
		</div>
	</div>
</div>