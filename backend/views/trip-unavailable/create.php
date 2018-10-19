<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TTripUnavailable */

$this->title = 'Create Ttrip Unavailable';
$this->params['breadcrumbs'][] = ['label' => 'Ttrip Unavailables', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ttrip-unavailable-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
