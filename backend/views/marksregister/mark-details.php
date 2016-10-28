<?php

use yii\helpers\Html;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel common\models\search\Marksregister */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Marks Register'.' - '.$grade_name;
$this->params['breadcrumbs'][] = ['label' => 'All Classes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="marksregister-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	
	<?php
		$attributes = array_merge(
			[['class' => 'yii\grid\SerialColumn']],
			[[
				'attribute' => 'student_display_name',
				'label' => 'Student Name',
				'format' => 'html',	
				'footer' => 'Total <br/> Average',
			]],
			$searchModel->getSubjectColumns($teacher_id, $grade_id)			
		);

		echo \yii\grid\GridView::widget([
			'dataProvider' => $dataProvider,
			'showFooter'=>TRUE,
			'footerRowOptions'=>['style'=>'font-weight:bold'],
			'columns' => $attributes
		]);
	?>

</div>
