<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Marksregister */

$this->title = 'Mark Entry';
$this->params['breadcrumbs'][] = ['label' => 'All Classes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $grade_name, 'url' => ['classview','id'=> $grade_id,]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="marksregister-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'subjectsList' => $subjectsList,
		'scenario' => $scenario
    ]) ?>

</div>
