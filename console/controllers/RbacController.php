<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // add "teacher" role and assign to the 'user'
        $teacher = $auth->createRole('teacher');
        $auth->add($teacher);
        $auth->assign($teacher, 1);
    }
}
