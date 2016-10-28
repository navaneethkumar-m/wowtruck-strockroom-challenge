<?php

namespace backend\controllers;

use Yii;
use common\models\Student;
use common\models\StudentGrade;
use common\models\TeacherGrade;
use common\models\search\Student as StudentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StudentController implements the CRUD actions for Student model.
 */
class StudentController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Student models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StudentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Student model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Student model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Student();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			// updating the students grade
			$studentGrade = new StudentGrade();
			$studentGrade->student_id = $model->id;
			$studentGrade->grade_id = $model->grade_id;
			if (!$studentGrade->save()) {
				return $this->render('create', [
                	'model' => $model,
            	]);
			}				
		 	return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Student model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			// updating the students grade
			$studentGrade = new StudentGrade();
			$studentGrade->student_id = $model->id;
			$studentGrade->grade_id = $model->grade_id;
			if (!$studentGrade->save()) {
				return $this->render('create', [
                	'model' => $model,
            	]);
			}	
			return $this->redirect(['index']);
        } else {
			$student_grade = StudentGrade::find()->where(['student_id' => $id])->one();			
			if(isset($student_grade->grade_id)){
				$grade_count = TeacherGrade::find()->where(['grade_id' => $student_grade->grade_id])->count();
				if($grade_count > 0)
					$model->grade_id = $student_grade->grade_id;
			}
			return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Student model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Student model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Student the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Student::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
