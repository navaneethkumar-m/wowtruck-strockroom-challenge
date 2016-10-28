<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "teacher_grade_subject".
 *
 * @property integer $id
 * @property integer $teacher_id
 * @property integer $grade_id
 * @property integer $subject_id
 *
 * @property Subject $subject
 * @property Grade $grade
 * @property Teacher $teacher
 */
class TeacherGradeSubject extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	public $subject_display_name;
	public $subjectCode;
	public $score;
    public static function tableName()
    {
        return 'teacher_grade_subject';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['teacher_id', 'grade_id', 'subject_id'], 'required'],
            [['teacher_id', 'grade_id', 'subject_id'], 'integer'],
            [['subject_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subject::className(), 'targetAttribute' => ['subject_id' => 'id']],
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
            'subject_id' => 'Subject ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubject()
    {
        return $this->hasOne(Subject::className(), ['id' => 'subject_id']);
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
     * @return \common\models\query\TeacherGradeSubjectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\TeacherGradeSubjectQuery(get_called_class());
    }
	
	/**
	* @param $teacher_id teacher id
	* @param $grade_id grade id
    * @return list of all teacher => grade => student.
    */
    public static function getTeacherGradeSubject($teacher_id,$grade_id)
    {
        return TeacherGradeSubject::find()
		->select(['subject_id', 'concat(name, "(", code, ")") as subject_display_name, subject.id as id, code as subjectCode'])
		->joinWith('subject')
		->where('grade_id = '+$grade_id +' and teacher_id = '+$teacher_id)
         ->all();	

    }
	
	
}
