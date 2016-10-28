<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TeacherGrade as TeacherGradeModel;

/**
 * TeacherGrade represents the model behind the search form about `common\models\TeacherGrade`.
 */
class TeacherGrade extends TeacherGradeModel
{
    /**
     * @inheritdoc
     */
	public $grade_display;
    public function rules()
    {
        return [
            [['teacher_id', 'grade_id'], 'integer'],
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
		// query joined with 'grade' and condition added
		$teacher_id = Yii::$app->session->get('user.teacher_id');
        $query = TeacherGradeModel::find()->select(['grade_id','concat(standard, " ", section, " (", code,")") as grade_display'])->joinWith('grade')
			->where(['teacher_id' => $teacher_id]);
		
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

        return $dataProvider;
    }
}
