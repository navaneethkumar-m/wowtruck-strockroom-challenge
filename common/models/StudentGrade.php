<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "student_grade".
 *
 * @property integer $id
 * @property integer $student_id
 * @property integer $grade_id
 *
 * @property Grade $grade
 * @property Student $student
 */
class StudentGrade extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	public $student_display_name;
	public $subjects = array();
    public static function tableName()
    {
        return 'student_grade';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'grade_id'], 'required'],
            [['student_id', 'grade_id'], 'integer'],
            [['grade_id'], 'exist', 'skipOnError' => true, 'targetClass' => Grade::className(), 'targetAttribute' => ['grade_id' => 'id']],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => Student::className(), 'targetAttribute' => ['student_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'student_id' => 'Student ID',
            'grade_id' => 'Grade ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrade()
    {
        return $this->hasOne(Grade::className(), ['id' => 'grade_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(Student::className(), ['id' => 'student_id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\StudentGradeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\StudentGradeQuery(get_called_class());
    }
	
	/**
	* @param $grade_id grade_id
    * @return list of all teacher => grade => student.
    */
    public static function getGradeStudentsList($grade_id)
    {
        return  StudentGrade::find()
		->select(['student_id','grade_id', 'concat(registration_no, " - ", first_name, " ", middle_name ," ", last_name) as student_display_name, student.id as id'])
		->joinWith('student')		
		->where(['grade_id' => $grade_id])
         ->all();	

    }
	
	/**
	* @param $grade_id grade_id
	* @param $student_id student_id
    * @return boolean - whether the Grade has the student.
    */
    public static function validateStudentGradeAvailable($grade_id,$student_id)
    {
        $count = StudentGrade::find()
		->where(['student_id' => $student_id, 'grade_id' => $grade_id])
        ->count();	
		if($count > 0)
			return true;
		else
			return false;
    }		
}
