<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TTrip */

$this->title = 'Create Trip';
$this->params['breadcrumbs'][] = ['label' => 'Trip List', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ttrip-create">
	<div class="well">
	    <h1><?= Html::encode($this->title) ?></h1>

	    <?= $this->render('_form', [
	        'model' => $model,
	        'listCategory' => $listCategory,
	        'listKeywords' => $listKeywords,
	        'modelTimelines' => $modelTimelines,
	        'listService'    => $listService,
	    ]) ?>
	</div>

</div>
