<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Marksregister as MarksregisterModel;
use common\models\StudentGrade;
use common\models\TeacherGradeSubject; 
use yii\helpers\Url;
use yii\helpers\Html;
/**
 * Marksregister represents the model behind the search form about `common\models\Marksregister`.
 */
class Marksregister extends MarksregisterModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'grade_id', 'student_id', 'score', 'updated_by'], 'integer'],
            [['updated_on'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
		$query = StudentGrade::find()
		->select(['grade_id','concat(first_name, " ", middle_name ," ", last_name, " - ", registration_no) as student_display_name, student.id as id'])
		->joinWith('student')
		->where('grade_id = '.$params['id']);
  
		// add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'grade_id' => $this->grade_id,
            'student_id' => $this->student_id,
            'score' => $this->score,
            'updated_on' => $this->updated_on,
            'updated_by' => $this->updated_by,
        ]);

        return $dataProvider;
    }
	
	/**
	 * @param $teacher_id teacher_id
	 * @param $grade id grade id
     * @return Dynamic subject columns with Custom actions for grid view
     */	
	function getSubjectColumns($teacher_id, $grade_id){	
		$attributes = [];
		$subjects_list = TeacherGradeSubject::getTeacherGradeSubject($teacher_id, $grade_id);
		foreach($subjects_list as $subject) {
            $attributes[] = [
					'attribute' => 'subjects',
					'label' => $subject->subject_display_name,
					'format' => 'html',
					'contentOptions'=>['style'=>'text-align:right;'],
					'value' => function ($model) use ($subject, $teacher_id, $grade_id) {                      
						return Marksregister::getMarkGradeStudentSubject($grade_id,$model->id,$subject->id);
					},
					'footer'=> Marksregister::getColumnSubjectTotal($grade_id,$subject->id)."<br/>".Marksregister::getColumnSubjectAverage($grade_id, $subject->id),
					'footerOptions'=>['style'=>'text-align:right;'],
				];
        }		
		$attributes[] = [
					'attribute' => 'subjects',
					'label' => 'Total',
					'format' => 'raw',
					'contentOptions'=>['style'=>'text-align:right;'],
					'value' => function ($model) use ($subjects_list, $teacher_id, $grade_id) {                      
						return Marksregister::getTotalMarksByGradeStudentSubject($grade_id,$model->id,$subjects_list);						
					},
				];		
		$attributes[] = [
					'attribute' => 'subjects',
					'label' => 'Average',
					'format' => 'raw',
					'contentOptions'=>['style'=>'text-align:right;'],
					'value' => function ($model) use ($subjects_list, $teacher_id, $grade_id) {                       
						return number_format(Marksregister::getAverageByGradeStudentSubject($grade_id,$model->id,$subjects_list),2);
					},
				];		
		$attributes[] = [ 'class' => 'yii\grid\ActionColumn', 
			 'template' => '{update}', 
			 'buttons' => [ 'update' => function ($url, $model) use ($grade_id) { 
				 $url = Url::to(['marksregister/update', 'grade_id' => $grade_id,'student_id' => $model->id]);
				 return Html::a( '<span class="glyphicon glyphicon-edit"> </span>', $url ); 
			 }], ];

        return $attributes;
	
	
	}
}
