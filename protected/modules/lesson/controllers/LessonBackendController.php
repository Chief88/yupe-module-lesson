<?php

/**
 * Class LessonBackendController
 */
class LessonBackendController extends yupe\components\controllers\BackController
{
    public   $aliasModule = 'LessonModule.lesson';
    public   $patchBackend = '/lesson/lessonBackend/';

    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin']],
            ['allow', 'actions' => ['create'], 'roles' => ['lesson.lessonBackend.Create']],
            ['allow', 'actions' => ['delete'], 'roles' => ['lesson.lessonBackend.Delete']],
            ['allow', 'actions' => ['index'], 'roles' => ['lesson.lessonBackend.Index']],
            ['allow', 'actions' => ['update', 'inline', 'sortable'], 'roles' => ['lesson.lessonBackend.Update']],
            ['deny']
        ];
    }

    public function actions()
    {
        return [
            'inline' => [
                'class'           => 'yupe\components\actions\YInLineEditAction',
                'model'           => 'Lesson',
                'validAttributes' => ['name', 'type_id', 'category_id', 'hall']
            ],
        ];
    }

	public function actionIndex(){
        $model = new Lesson('search');

        $model->unsetAttributes();

        $model->setAttributes(
            Yii::app()->getRequest()->getParam(
                'Lesson', []
            )
        );

        $this->render(
            'index', [
                'model' => $model,
            ]
        );
	}

    public function actionCreate(){
        $model = new Lesson();

        if(isset($_POST['Lesson'])){
            $model->attributes = $_POST['Lesson'];
            if($model->validate()){
                $model->save();

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t($this->aliasModule, 'Lesson create!')
                );

                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost(
                        'submit-type',
                        ['create']
                    )
                );
            }
        }

        $this->render(
            'create', [
                'model' => $model,
            ]
        );
	}

    public function actionUpdate($id){

        // Указан ID страницы, редактируем только ее
        $model = $this->loadModel($id);

        if (($data = Yii::app()->getRequest()->getPost('Lesson')) !== null) {

            $model->setAttributes($data);

            if ($model->save()) {

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t($this->aliasModule, 'Lesson update!')
                );

                $this->redirect(
                    (array) Yii::app()->getRequest()->getPost(
                        'submit-type', ['update', 'id' => $model->id]
                    )
                );
            }
        }

        $this->render(
            'update', [
                'model'        => $model,
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
                Yii::t($this->aliasModule, 'Lesson deleted!')
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
        if (($model = Lesson::model()->findByPk($id)) === null) {
            throw new CHttpException(
                404,
                Yii::t($this->aliasModule, 'Requested page was not found!')
            );
        }

        return $model;
    }

}