<?php

namespace backend\controllers;

use Yii;
use common\models\Grade;
use common\models\Student;
use common\models\StudentGrade;
use common\models\Marksregister;
use common\models\TeacherGrade;
use common\models\TeacherGradeSubject;
use common\models\search\Marksregister as MarksregisterSearch;
use common\models\search\TeacherGrade as TeacherGradeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;

/**
 * MarksRegisterController implements the CRUD actions for Marksregister model.
 */
class MarksregisterController extends Controller
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
     * Lists all Marksregister models.
     * @return mixed
     */
    public function actionIndex()
    {
		$teacher_id = Yii::$app->session->get('user.teacher_id');
		if($teacher_id == 0)
			return $this->redirect(['site/index']);
		$searchModel = new TeacherGradeSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
    }
	
	
	/**
     * Displays a single class Marks Report.
     * @param integer $id
     * @return mixed
     */
    public function actionClassview($id)
    {		
		$teacher_id = Yii::$app->session->get('user.teacher_id');
		if($teacher_id == 0)
			return $this->redirect(['site/index']);
		
		$isTeacherAccessValid =  TeacherGrade::validateTeacherGradeAccess($teacher_id, $id);
		if($isTeacherAccessValid) {
			$studentsList = StudentGrade::getGradeStudentsList($id);
			$grade_name = Grade::getClassNameByGrade($id);
			$searchModel = new MarksregisterSearch();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			return $this->render('mark-details', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
				'studentsList' => $studentsList,
				'grade_name' => $grade_name,
				'grade_id' => $id,
				'teacher_id' => $teacher_id,
			]);	
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');		
		}
    }
	
    /**
     * Updates an existing Marksregister model.
     * If update is successful, the browser will be redirected to the 'classview' page.
     * @param $grade_id grade id
	 * @param $student_id student id
     * @return mixed
     */
    public function actionUpdate($grade_id, $student_id)
    {     
		$teacher_id = Yii::$app->session->get('user.teacher_id');
		if($teacher_id == 0)
			return $this->redirect(['site/index']);
		
		$grade_name = Grade::getClassNameByGrade($grade_id);
		$subjectsList = TeacherGradeSubject::getTeacherGradeSubject($teacher_id,$grade_id);
		$subjectsList = MarksRegister::getMarksListByGradeStudentSubject($grade_id,$student_id,$subjectsList);

		$isTeacherAccessValid =  TeacherGrade::validateTeacherGradeAccess($teacher_id, $grade_id); 
		$isGradeStudentAvail = StudentGrade::validateStudentGradeAvailable($grade_id, $student_id);
		
		if($isTeacherAccessValid && $isGradeStudentAvail) {		
			if (Yii::$app->request->post()) {
            $transaction = Yii::$app->db->beginTransaction();
			try {
				$postValues = Yii::$app->request->post();
				if(isset($postValues['Marksregister']['subjects']) && count($postValues['Marksregister']['subjects']) > 0) {
					foreach(($postValues['Marksregister']['subjects'])	 as $key => $value) {
						$model = $this->findModelByGradeStudentSubject($grade_id,$student_id, $key);						
						$model->subject_id = $key;
						$model->score = $value;
						$model->updated_by = Yii::$app->user->id;
						$model->updated_on = new Expression('NOW()');
						$model->save();							
					}
					$transaction->commit();
					return $this->redirect(['classview', 'id' => $grade_id]);
				}
			}  catch (Exception $e) {
				$transaction->rollBack();
				return $this->render('update', [
					'model' => $model,
					'subjectsList' => $subjectsList,
					'scenario' => 'update',
					'grade_name' => $grade_name,
					'grade_id' => $grade_id,
           		 ]);
			}			
        } else {
			$model = new Marksregister();
			$model->grade_id = $grade_id;
			$model->student_id = $student_id;
            return $this->render('update', [
                'model' => $model,
				'subjectsList' => $subjectsList,
				'scenario' => 'update',
				'grade_name' => $grade_name,
				'grade_id' => $grade_id,
            ]);
        }	
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');		
		}
		
        
    }
    /**
     * Finds the Marksregister model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Marksregister the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Marksregister::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	/**
     * Finds the Marksregister model based on its grade_id, student_id, subject_id
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $grade_id
	 * @param integer $student_id
	 * @param integer $subject_id
     * @return Marksregister the loaded model
     */
    protected function findModelByGradeStudentSubject($grade_id, $student_id, $subject_id)
    {
        if (($model = Marksregister::find()->where(['grade_id' => $grade_id, 'student_id' => $student_id, 'subject_id' => $subject_id])->one()) !== null) {
            return $model;
        } else {
			$model = new Marksregister();
			$model->grade_id = $grade_id;
			$model->student_id = $student_id;
			$model->subject_id = $subject_id;   
			return $model;
        }
    }
}
