<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TCategory */

$this->title = 'Add Category';
?>
<div class="tcategory-create">

    <?= $this->render('_form', [
        'model' => $model,
        'listItemType' => $listItemType,
        'listKeywords' => $listKeywords,
    ]) ?>

</div>
