<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TBlog */

$this->title = 'Update Tblog: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Tblogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tblog-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
