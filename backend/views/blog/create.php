<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TBlog */

$this->title = 'Create Tblog';
$this->params['breadcrumbs'][] = ['label' => 'Tblogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblog-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
