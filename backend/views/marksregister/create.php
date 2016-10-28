<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Marksregister */

$this->title = 'Create Marksregister';
$this->params['breadcrumbs'][] = ['label' => 'Marksregisters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="marksregister-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'subjectsList' => $subjectsList,
		'scenario' => $scenario
    ]) ?>

</div>
