<?php

/**
 * Class TimetableBackendController
 */
class TimetableBackendController extends yupe\components\controllers\BackController
{
    public   $aliasModule = 'LessonModule.lesson';
    public   $patchBackend = '/lesson/timetableBackend/';

    public function beforeAction(){
        $emptyDates = Timetable::model()->findAll();
        foreach ($emptyDates as $emptyDate) {
            if(!$emptyDate->timetableLesson){
                $emptyDate->delete();
            }
        }

        return true;
    }

    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin']],
            ['allow', 'actions' => ['create'], 'roles' => ['lesson.timetableBackend.Create']],
            ['allow', 'actions' => ['delete'], 'roles' => ['lesson.timetableBackend.Delete']],
            ['allow', 'actions' => ['index'], 'roles' => ['lesson.timetableBackend.Index']],
            ['allow', 'actions' => ['update', 'inline', 'sortable'], 'roles' => ['lesson.timetableBackend.Update']],
            ['deny']
        ];
    }

    public function actions()
    {
        return [
            'inline' => [
                'class'           => 'yupe\components\actions\YInLineEditAction',
                'model'           => 'TimetableLesson',
                'validAttributes' => ['lesson_id', 'time_id', 'staff_id']
            ],
        ];
    }

    public function actionIndex(){
        $model = new TimetableLesson('search');

        $model->unsetAttributes();

        $model->setAttributes(
            Yii::app()->getRequest()->getParam(
                'TimetableLesson', []
            )
        );

        $this->render('index', [
                'model' => $model,
            ]
        );
    }

    public function actionCreate(){
        $model = new Timetable();

        if(Yii::app()->getRequest()->getIsPostRequest() && Yii::app()->getRequest()->getPost('Timetable')){
            $timetable = Yii::app()->getRequest()->getPost('Timetable');
            $model->attributes = $timetable;

            $flag = false;
            if($model->validate()){
                if($model->save()){
                    $flag = true;

                    if(isset($timetable['lessons'])){

                        foreach($timetable['lessons'] as $lesson){
                            $timetableLesson = new TimetableLesson();

                            $timetableLesson->date_id = $model->id;
                            $timetableLesson->attributes = $lesson;

                            if($timetableLesson->validate()){
                                if($timetableLesson->save()){
                                    $flag = true;
                                }else{
                                    Yii::app()->user->setFlash(
                                        yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                                        Yii::t($this->aliasModule, 'Error add lesson!')
                                    );
                                    continue;
                                };
                            }
                        }
                    }else{
                        $timetableLesson = new TimetableLesson();

                        $timetableLesson->date_id = $model->id;

                        if($timetableLesson->validate()){
                            if($timetableLesson->save()){
                                $flag = true;
                            }
                        }
                    }

                }
            }

            if($flag){
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t($this->aliasModule, 'Created!')
                );

                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost(
                        'submit-type',
                        ['create']
                    )
                );
            }else{
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                    Yii::t($this->aliasModule, 'Error!')
                );

                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost(
                        'submit-type',
                        ['create']
                    )
                );
            }
        }

        $this->render('create', [
                'model' => $model,
            ]
        );
    }

    public function actionUpdate($id){

        // Указан ID страницы, редактируем только ее
        $model = $this->loadModel($id);

        if(Yii::app()->getRequest()->getIsPostRequest() && Yii::app()->getRequest()->getPost('Timetable')){
            $timetable = Yii::app()->getRequest()->getPost('Timetable');
            $model->attributes = $timetable;

            $flag = false;
            if($model->validate()){
                if($model->save()){
                    $flag = true;

                    if(isset($timetable['lessons'])){
                        foreach($timetable['lessons'] as $lesson){
                            if(isset($lesson['id'])){
                                $timetableLesson = TimetableLesson::model()->findByPk($lesson['id']);

                            }else{
                                $timetableLesson = new TimetableLesson();

                            }

                            $timetableLesson->date_id = $model->id;
                            $timetableLesson->attributes = $lesson;

                            if($timetableLesson->validate()){
                                if($timetableLesson->save()){
                                    $flag = true;
                                }else{
                                    continue;
                                };
                            }
                        }
                    }

                }
            }

            if($flag){
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t($this->aliasModule, 'Updated!')
                );

            }else{
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                    Yii::t($this->aliasModule, 'Error!')
                );
            }

            $this->redirect(
                (array)Yii::app()->getRequest()->getPost(
                    'submit-type',
                    ['update', 'id' => $model->id]
                )
            );
        }

        $this->render('update', [
                'model' => $model,
            ]
        );

    }

    public function actionDelete($id = null){
        if (Yii::app()->getRequest()->getIsPostRequest()) {

            $model = $this->loadModel($id);

            // we only allow deletion via POST request
            $model->delete();

            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t($this->aliasModule, 'Deleted!')
            );

            // если это AJAX запрос ( кликнули удаление в админском grid view), мы не должны никуда редиректить
            Yii::app()->getRequest()->getParam('ajax') !== null || $this->redirect(
                (array) Yii::app()->getRequest()->getPost('returnUrl', 'index')
            );
        } else {
            throw new CHttpException(
                404,
                Yii::t($this->aliasModule, 'Bad request. Please don\'t repeat similar requests anymore!')
            );
        }
    }

    public function loadModel($id)
    {
        if (($model = Timetable::model()->findByPk($id)) === null) {
            throw new CHttpException(
                404,
                Yii::t($this->aliasModule, 'Requested page was not found!')
            );
        }

        return $model;
    }

    public function actionDeleteLesson($id = null){
        if (Yii::app()->getRequest()->getIsPostRequest()) {

            if (($model = TimetableLesson::model()->findByPk($id)) === null) {
                throw new CHttpException(
                    404,
                    Yii::t($this->aliasModule, 'Requested page was not found!')
                );
            }

            // we only allow deletion via POST request
            $model->delete();

            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t($this->aliasModule, 'Deleted!')
            );

            // если это AJAX запрос ( кликнули удаление в админском grid view), мы не должны никуда редиректить
            Yii::app()->getRequest()->getParam('ajax') !== null || $this->redirect(
                (array) Yii::app()->getRequest()->getPost('returnUrl', 'index')
            );
        } else {
            throw new CHttpException(
                404,
                Yii::t($this->aliasModule, 'Bad request. Please don\'t repeat similar requests anymore!')
            );
        }
    }

}