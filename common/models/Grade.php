<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "grade".
 *
 * @property integer $id
 * @property string $standard
 * @property string $section
 * @property string $code
 * @property integer $status
 *
 * @property Marksregister[] $marksregisters
 * @property StudentGrade[] $studentGrades
 * @property TeacherGrade[] $teacherGrades
 */
class Grade extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	public $grade_display;
    public static function tableName()
    {
        return 'grade';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['standard', 'section', 'code', 'status'], 'required'],
            [['status'], 'integer'],
            [['standard', 'section', 'code'], 'string', 'max' => 50],
            [['code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'standard' => 'Standard',
            'section' => 'Section',
            'code' => 'Code',
            'status' => 'Status',
        ];
    }

    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentGrades()
    {
        return $this->hasMany(StudentGrade::className(), ['grade_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacherGrades()
    {
        return $this->hasMany(TeacherGrade::className(), ['grade_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\GradeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\GradeQuery(get_called_class());
    }
	
	/**
	 * @param grade id
     * @return Formatted Class name
     */
    public function getClassNameByGrade($grade_id)
    {
		$data = Grade::find()->select(['concat(standard, " ", section, " (", code,")") as grade_display'])->where(['id' => $grade_id])->one();
		if($data->grade_display)
			return $data->grade_display;
		else
			return $grade_id;
    }
}
