<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Student as StudentModel;

/**
 * Student represents the model behind the search form about `common\models\Student`.
 */
class Student extends StudentModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'registration_no', 'status'], 'integer'],
            [['first_name', 'middle_name', 'last_name', 'registered_on', 'date_of_birth'], 'safe'],
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
		// query included with join on StudentGrades
        $query = StudentModel::find()->select(['student.id','student_id','grade_id','first_name','middle_name','last_name','registration_no','date_of_birth','status'])->joinWith('studentGrades');

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
            'registration_no' => $this->registration_no,
            'registered_on' => $this->registered_on,
            'date_of_birth' => $this->date_of_birth,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name]);

        return $dataProvider;
    }
}
