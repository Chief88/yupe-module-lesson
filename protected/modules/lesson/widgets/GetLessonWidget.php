<?php
class GetLessonWidget extends yupe\widgets\YWidget{

    public $nameContact;
    public $view = 'listLesson';
    public $categorySlug;
    public $typeSlug;
    public $limit = false;
    public $params = [];

    public function init(){

    }

    public function run(){

        $criteria = new CDbCriteria();
        $criteria->with[] = 'category';
        $criteria->with[] = 'type';
        if( !empty($this->categorySlug) ){
            $criteria->addCondition('category.slug = :categorySlug');
            $criteria->params['categorySlug'] =  $this->categorySlug;
        }

        if( !empty($this->typeSlug) ){
            $criteria->addCondition('type.slug = :typeSlug');
            $criteria->params['typeSlug'] =  $this->typeSlug;
        }

        if($this->limit){
            $criteria->limit = $this->limit;
        }

        $models = Lesson::model()->findAll($criteria);

        if (count($models) > 0) {
            $this->render($this->view, [
                'models'        => $models,
                'params'        => $this->params,
                'typeSlug'      => $this->typeSlug,
                'categorySlug'  => $this->categorySlug,
            ]);
        }

    }
}