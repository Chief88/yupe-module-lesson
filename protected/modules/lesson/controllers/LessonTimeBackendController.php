<?php

class LessonTimeBackendController extends yupe\components\controllers\BackController
{

    public   $aliasModule = 'LessonModule.lesson';
    public   $patchBackend = '/lesson/lessonTimeBackend/';

    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin']],
            ['allow', 'actions' => ['create'], 'roles' => ['lesson.lessonTimeBackend.Create']],
            ['allow', 'actions' => ['delete'], 'roles' => ['lesson.lessonTimeBackend.Delete']],
            ['allow', 'actions' => ['index'], 'roles' => ['lesson.lessonTimeBackend.Index']],
            ['allow', 'actions' => ['update', 'inline', 'sortable'], 'roles' => ['lesson.lessonTimeBackend.Update']],
            ['deny']
        ];
    }

    public function actions()
    {
        return [
            'inline' => [
                'class'           => 'yupe\components\actions\YInLineEditAction',
                'model'           => 'LessonTime',
                'validAttributes' => ['time_begin']
            ],
            'sortable' => [
                'class' => 'yupe\components\actions\SortAction',
                'model' => 'LessonTime',
                'attribute' => 'sort'
            ]
        ];
    }
    
	public function actionIndex(){
        $model = new LessonTime('search');

        $model->unsetAttributes();

        $model->setAttributes(
            Yii::app()->getRequest()->getParam(
                'LessonTime', []
            )
        );

        $this->render(
            'index', [
                'model' => $model,
            ]
        );
	}

    public function actionCreate(){

        $model = new LessonTime();

        if (($data = Yii::app()->getRequest()->getPost('LessonTime')) !== null) {
            $model->setAttributes($data);

                if ($model->save()) {

                    Yii::app()->user->setFlash(
                        yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                        Yii::t($this->aliasModule, 'Time lesson create!')
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
        ]);

	}

    public function actionUpdate($id){

        // Указан ID страницы, редактируем только ее
        $model = $this->loadModel($id);

        if (($data = Yii::app()->getRequest()->getPost('LessonTime')) !== null) {

            $model->setAttributes($data);

            if ($model->save()) {

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t($this->aliasModule, 'Time lesson update!')
                );

                $this->redirect(
                    (array) Yii::app()->getRequest()->getPost(
                        'submit-type', [
                            'update', 
                            'id' => $model->id
                        ]
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
                Yii::t($this->aliasModule, 'Time lesson deleted!')
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
        if (($model = LessonTime::model()->findByPk($id)) === null) {
            throw new CHttpException(
                404,
                Yii::t($this->aliasModule, 'Requested page was not found!')
            );
        }

        return $model;
    }

}