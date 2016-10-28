<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "teacher_grade".
 *
 * @property integer $id
 * @property integer $teacher_id
 * @property integer $grade_id
 *
 * @property Grade $grade
 * @property Teacher $teacher
 */
class TeacherGrade extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	public $grade_display;
    public static function tableName()
    {
        return 'teacher_grade';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['teacher_id', 'grade_id'], 'required'],
            [['teacher_id', 'grade_id'], 'integer'],
            [['grade_id'], 'exist', 'skipOnError' => true, 'targetClass' => Grade::className(), 'targetAttribute' => ['grade_id' => 'id']],
            [['teacher_id'], 'exist', 'skipOnError' => true, 'targetClass' => Teacher::className(), 'targetAttribute' => ['teacher_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'teacher_id' => 'Teacher ID',
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
    public function getTeacher()
    {
        return $this->hasOne(Teacher::className(), ['id' => 'teacher_id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\TeacherGradeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\TeacherGradeQuery(get_called_class());
    }
	
	/**
	* @param $teacher_id teacher id
	* @param $grade_id grade id
    * @return boolean - whether the Teacher have access to the Grade.
    */
    public static function validateTeacherGradeAccess($teacher_id, $grade_id)
    {
        $count = TeacherGrade::find()
		->where(['teacher_id' => $teacher_id, 'grade_id' => $grade_id])
        ->count();	
		if($count > 0)
			return true;
		else
			return false;
    }	
	
	/**
	* @param $teacher_id teacher id
    * @return formatted grade name for display.
    */
    public static function findFormatted($teacher_id)
    {
        return TeacherGrade::find()
		->select(['grade_id','concat(standard, " ", section, "(", code, ")") as grade_display, grade.id as id'])
		->joinWith('grade')
		->where('teacher_id = '+$teacher_id)
        ->asArray()
        ->all();	
    }	
	
}
