<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\Marksregister */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Classes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="marksregister-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
            	'attribute' => 'grade_display',
            	'label' => 'Grade name',
        	],
			[ 'class' => 'yii\grid\ActionColumn', 
			 'template' => '{classview}', 
			 'buttons' => [ 'classview' => function ($url, $model) { 
				 $url .= $model->grade_id;
				 return Html::a( '<span class="glyphicon glyphicon-edit"> </span>', $url ); 
			 }], ]
        	],
    ]); ?>
</div>
