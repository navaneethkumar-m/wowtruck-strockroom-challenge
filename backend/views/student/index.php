<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Grade;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Student */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Students';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Student', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'first_name',
            'middle_name',
            'last_name',
			[
				'attribute' => 'grade_id',
				'label' => 'Class',
				'format' => 'raw',
				'contentOptions'=>['style'=>'text-align:right;'],
				'value' => function ($model) {             
					if($model->grade_id != '')
						return Grade::getClassNameByGrade($model->grade_id);
					else
						return '';
				},
			],
            'registration_no',
            //'registered_on',
            'date_of_birth',
        	[
            	'attribute' => 'status',
            	'value' => function($model) {
    				return $model->status == 1 ? 'Active' : 'Not Active';
				}
        	],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
