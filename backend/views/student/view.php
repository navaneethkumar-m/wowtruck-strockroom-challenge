<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Student;

/* @var $this yii\web\View */
/* @var $model app\models\Student */

$this->title = Student::getStudentDisplayName($model->id);
$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="student-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'first_name',
            'middle_name',
            'last_name',
            'registration_no',
            'registered_on',
            'date_of_birth',
            [
            	'attribute' => 'status',
            	'value' => $model->status == 1 ? 'Active' : 'Not Active'
        	],
        ],
    ]) ?>

</div>
