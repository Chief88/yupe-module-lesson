<?php

/**
 * Class LessonController
 */
class LessonController extends yupe\components\controllers\FrontController{

    public function actionIndex(){

        $categoryModel = '';
        if (\Yii::app()->hasModule('category')) {
            $categoryModel = \Category::model()->findByAttributes(['slug' => 'stranica-kontakty']);
        }

        $this->render('index', [
            'categoryModel' => $categoryModel,
        ]);
    }
    
    public function actionShow($slug){

        $model = Lesson::model()->findByAttributes(['slug' => $slug]);

        $this->render('show', [
                'model' => $model,
            ]
        );
    }

}
