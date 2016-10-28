<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\TeacherGrade;
use common\models\StudentGrade;
use common\models\Student;

/* @var $this yii\web\View */
/* @var $model common\models\Marksregister */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="marksregister-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<?php if($scenario == 'update') { ?>
   		<?= $form->field($model, 'grade_id')->dropDownList(ArrayHelper::map(TeacherGrade::findFormatted(1), 'id', 'grade_display'),['disabled' => 'disabled'])?>
	<?php } else { ?>
		<?= $form->field($model, 'grade_id')->dropDownList(ArrayHelper::map(TeacherGrade::findFormatted(1), 'id', 'grade_display'))?>
	<?php } ?>
	
	<?php if($scenario == 'update') { ?>
   		<?= $form->field($model, 'student_id')->dropDownList(ArrayHelper::map(StudentGrade::getGradeStudentsList(1), 'id', 'student_display_name'),['disabled' => 'disabled'])?>
	<?php } else { ?>
		<?= $form->field($model, 'student_id')->dropDownList(ArrayHelper::map(StudentGrade::getGradeStudentsList(1), 'id', 'student_display_name'))?>
	<?php } ?>	
	
	<?php foreach ($subjectsList as $subject) { ?>

    <?php echo $form->field($model, 'subjects['.$subject->id.']')->textInput(['value' => $subject->score])->label($subject->subject_display_name); ?>
	
	<?php } ?>
	
    <div class="form-group">
        <?= Html::submitButton(($scenario == 'create') ? 'Create' : 'Update', ['class' => ($scenario == 'create') ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
