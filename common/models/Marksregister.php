<?php

namespace common\models;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;

use Yii;

/**
 * This is the model class for table "marksregister".
 *
 * @property integer $id
 * @property integer $grade_id
 * @property integer $student_id
 * @property integer $score
 * @property string $updated_on
 * @property integer $updated_by
 *
 * @property User $updatedBy
 * @property Grade $grade
 * @property Student $student
 */
class Marksregister extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	public $subjects;
	
    public static function tableName()
    {
        return 'marksregister';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['grade_id', 'student_id', 'score', 'updated_on', 'updated_by'], 'required'],
            [['grade_id', 'student_id', 'score', 'updated_by'], 'integer'],
			['subjects', 'integer', 'min'=>0, 'max'=>100],
            [['updated_on'], 'safe'],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['grade_id'], 'exist', 'skipOnError' => true, 'targetClass' => Grade::className(), 'targetAttribute' => ['grade_id' => 'id']],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => Student::className(), 'targetAttribute' => ['student_id' => 'id']],
        ];
    }
	
	public function isValidMark($attribute, $params)
	{
		$this->addError($attribute, 'must contain exactly 8 digits.');
		if (is_int($this->$attribute) && $this->$attribute >= 0 && $this->$attribute <=100) {
			//
		} else {
			$this->addError($attribute, 'must contain exactly 8 digits.');
		}
	}

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'grade_id' => 'Grade ID',
            'student_id' => 'Student ID',
            'score' => 'Score',
            'updated_on' => 'Updated On',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
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
     * @return \common\models\query\MarksregisterQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\MarksregisterQuery(get_called_class());
    }
	
	
	public function behaviors()
    {
        return array_merge(parent::behaviors(), [
  			 [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['updated_on'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_on'],
                ],
				'value' => new Expression('NOW()'), 
             ],
			[
				'class' => BlameableBehavior::className(),
				'createdByAttribute' => 'updated_by',
				'updatedByAttribute' => 'updated_by',
       	 	],
        ]);
    }
	
	/**
	 * @param $grade_id grade_id
	 * @param $student_id student_id
	 * @param $subject_list list of subjects
     * @return Marks list by grade, student and subject list
     */	
	public function getMarksListByGradeStudentSubject($grade_id, $student_id, $subject_list)
    {
		foreach($subject_list as $key => $value) {			
			$data = Marksregister::find()->where(['grade_id' => $grade_id, 'student_id' => $student_id, 'subject_id' => $value->id])->one();
			if(isset($data->score))
				$subject_list[$key]->score = $data->score;
			else
				$subject_list[$key]->score = '';
		}	
		return $subject_list;
	}	
		
	/**
	 * @param $grade_id grade_id
	 * @param $subject_id subject_id
	 * @return Subject total by grade, subject
     */	
	public function getColumnSubjectTotal($grade_id, $subject_id)
    {
		$data = Marksregister::find()->where(['grade_id' => $grade_id, 'subject_id' => $subject_id])->sum('score');
		return $data;
	}

	/**
	 * @param $grade_id grade_id
	 * @param $subject_id subject_id
	 * @return Subject average by grade, subject
     */	
	public function getColumnSubjectAverage($grade_id, $subject_id)
    {
		$data_count = Marksregister::find()->where(['grade_id' => $grade_id, 'subject_id' => $subject_id])->count('score');
		
		if($data_count == 0)
			return 0;
		else {
			$sum = $this->getColumnSubjectTotal($grade_id, $subject_id);
			return number_format($sum/$data_count,2);
		}
	}
	
	/**
	 * @param $grade_id grade_id
	 * @param $student_id student_id
	 * @param $subject_id subject_id
	 * @return Student mark by grade, student and subject
     */			
	public function getMarkGradeStudentSubject($grade_id, $student_id, $subject_id)
    {
		$data = Marksregister::find()->where(['grade_id' => $grade_id, 'student_id' => $student_id, 'subject_id' => $subject_id])->one();
		if(isset($data->score))
			return $data->score;
		else
			return '';
	}
	
	/**
	 * @param $grade_id grade_id
	 * @param $student_id student_id
	 * @param $subject_list list of subjects
     * @return Student total by grade, student and subject list
     */		
	public function getTotalMarksByGradeStudentSubject($grade_id, $student_id, $subject_list)
    {
		$total = 0;
		foreach($subject_list as $key => $value) {			
			$data = Marksregister::find()->where(['grade_id' => $grade_id, 'student_id' => $student_id, 'subject_id' => $value->id])->one();
			if(isset($data->score))
				$total += $data->score;
			else
				$total += 0;
		}	
		return $total;
	}

	/**
	 * @param $grade_id grade_id
	 * @param $student_id student_id
	 * @param $subject_list list of subjects
     * @return Student average by grade, student and subject list
     */		
	public function getAverageByGradeStudentSubject($grade_id, $student_id, $subject_list)
    {
		$total = 0;
		if(count($subject_list) == 0)
			return 0;
		foreach($subject_list as $key => $value) {			
			$data = Marksregister::find()->where(['grade_id' => $grade_id, 'student_id' => $student_id, 'subject_id' => $value->id])->one();
			if(isset($data->score))
				$total += $data->score;
			else
				$total += 0;
		}	
		return $total/count($subject_list);
	}
}
