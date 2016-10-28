<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use common\models\TeacherGrade;


/* @var $this yii\web\View */
/* @var $model app\models\Student */
/* @var $form yii\widgets\ActiveForm */
//print_r(TeacherGrade::findFormatted(1));
?>

<div class="student-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'registration_no')->textInput() ?>

	<?= $form->field($model, 'date_of_birth')->widget(DatePicker::className(),['clientOptions' => ['periodfrom' => '2000-01-01', 'changeYear' => true, 'changeMonth' => true],'dateFormat' => 'yyyy-MM-dd']) ?> 
	
    <?= $form->field($model, 'registered_on')->widget(DatePicker::className(),['clientOptions' => ['periodfrom' => '2000-01-01'],'dateFormat' => 'yyyy-MM-dd']) ?> 

    <?= $form->field($model, 'status')->dropDownList(['1' => 'Active', '0' => 'Not Active'])?>
	<?php if($model->grade_id == "") { ?>
		<?= $form->field($model, 'grade_id')->dropDownList(ArrayHelper::map(TeacherGrade::findFormatted(1), 'id', 'grade_display'),['prompt'=>'Select...'])?>
	<?php } else {  ?>	
		<?= $form->field($model, 'grade_id')->dropDownList(ArrayHelper::map(TeacherGrade::findFormatted(1), 'id', 'grade_display'),['prompt'=>'Select...','disabled' => 'disabled'])?>
	<?php } ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
