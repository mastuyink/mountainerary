<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
$this->title = $page['title'];
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag([
    'name'    => 'description',
    'content' => $page['meta_description'],
]);
$this->registerMetaTag([
    'name'    => 'keywords',
    'content' => implode(', ',ArrayHelper::map($page['usedKeywords'], 'id', 'idKeyword.keyword')),
]);
?>
<div class="row">
	<div class="col-md-12">
    <h1 class="font-24"><?= Html::encode($this->title) ?></h1>
    <div class="material-card">
        <div class="material-card_content">
            <?= $page['content'] ?>
        </div>
	</div>
	</div>
	</div>
	</div>
</div>
