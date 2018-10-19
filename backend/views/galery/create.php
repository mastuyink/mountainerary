<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TGalery */

$this->title = 'Create Tgalery';
$this->params['breadcrumbs'][] = ['label' => 'Tgaleries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tgalery-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
