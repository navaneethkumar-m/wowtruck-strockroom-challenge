<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "teacher".
 *
 * @property integer $id
 * @property string $salutation
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property integer $emp_id
 * @property string $joined_on
 * @property string $date_of_birth
 * @property integer $status
 *
 * @property TeacherGrade[] $teacherGrades
 * @property TeacherUser[] $teacherUsers
 */
class Teacher extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'teacher';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['salutation', 'first_name', 'last_name', 'emp_id', 'joined_on', 'date_of_birth', 'status'], 'required'],
            [['emp_id', 'status'], 'integer'],
            [['joined_on', 'date_of_birth'], 'safe'],
            [['salutation'], 'string', 'max' => 16],
            [['first_name', 'middle_name', 'last_name'], 'string', 'max' => 50],
            [['emp_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'salutation' => 'Salutation',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'last_name' => 'Last Name',
            'emp_id' => 'Emp ID',
            'joined_on' => 'Joined On',
            'date_of_birth' => 'Date Of Birth',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacherGrades()
    {
        return $this->hasMany(TeacherGrade::className(), ['teacher_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacherUsers()
    {
        return $this->hasMany(TeacherUser::className(), ['teacher_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\TeacherQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\TeacherQuery(get_called_class());
    }
}
