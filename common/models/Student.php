<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "student".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property integer $registration_no
 * @property string $registered_on
 * @property string $date_of_birth
 * @property integer $status
 *
 * @property Marksregister[] $marksregisters
 * @property StudentGrade[] $studentGrades
 */
class Student extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	public $grade_id;
	public $student_display_name;
	
    public static function tableName()
    {
        return 'student';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'registration_no', 'registered_on', 'date_of_birth', 'status'], 'required'],
            [['registration_no', 'status'], 'integer'],
            [['registered_on', 'date_of_birth'], 'safe'],
            [['first_name', 'middle_name', 'last_name'], 'string', 'max' => 50],
            [['registration_no'], 'unique'],
			[['grade_id'] , 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'last_name' => 'Last Name',
            'registration_no' => 'Registration No',
            'registered_on' => 'Registered On',
            'date_of_birth' => 'Date Of Birth',
            'status' => 'Status',
			'grade_id' => 'Grade'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMarksregisters()
    {
        return $this->hasMany(Marksregister::className(), ['student_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentGrades()
    {
        return $this->hasMany(StudentGrade::className(), ['student_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\StudentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\StudentQuery(get_called_class());
    }
	
	/**
	* @param student_id student id
    * @return formatted return data - Student name.
    */
    public static function getStudentDisplayName($student_id)
    {
        $data = Student::find()
		->select(['concat(first_name, " ", middle_name ," ", last_name, " - ", registration_no) as student_display_name, id as id'])
		->where(['id' => $student_id])
        ->one();	
	
		if(isset($data->student_display_name))
			return $data->student_display_name;
		else
			return $student_id;
    }
	
	/**
	* @param student_id student id
    * @return formatted return data - Student name All.
    */
    public static function getStudentDisplayNameAll($student_id)
    {
        $data = Student::find()
		->select(['concat(first_name, " ", middle_name ," ", last_name, " - ", registration_no) as student_display_name, id as id'])
		->where(['id' => $student_id])
        ->all();	
	
		if(isset($data->student_display_name))
			return $data->student_display_name;
		else
			return $student_id;
    }
}
