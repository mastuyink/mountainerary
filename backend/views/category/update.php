<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TCategory */

$this->title = 'Update Category';
?>
<div class="tcategory-update">


    <?= $this->render('_form', [
        'model' => $model,
        'listItemType' => $listItemType,
        'listKeywords' => $listKeywords,
    ]) ?>

</div>
