<?php

/**
 * Class LessonController
 */
class LessonController extends yupe\components\controllers\FrontController{

    /**
     * Отображение страницы "Расписание"
     */
    public function actionIndex($category = false, $type = false, $teacher = false, $time = false){

        $isFilter = false;

        $criteria = new CDbCriteria();
        $criteria->with[] = 'lesson';
        $criteria->with[] = 'teacher';
        $criteria->with[] = 'time';
        $criteria->with[] = 'date';

        if($category){
            $criteria->addCondition('category.slug = :categorySlug');
            $criteria->params['categorySlug'] = $category;
            $isFilter = true;
        }

        if($type){
            $criteria->addCondition('type.slug = :typeSlug');
            $criteria->params['typeSlug'] = $type;
            $isFilter = true;
        }

        if($teacher){
            $teacher = trim($teacher);
            $words = explode(' ', $teacher);
            $criteria->addCondition('teacher.last_name = :words1 AND teacher.first_name = :words2');
//            $criteria->addCondition('teacher.last_name = :words1 AND teacher.first_name = :words3 AND teacher.patronymic = :words2', 'OR');
            $criteria->addCondition('teacher.last_name = :words2 AND teacher.first_name = :words1', 'OR');
//            $criteria->addCondition('teacher.last_name = :words2 AND teacher.first_name = :words3 AND teacher.patronymic = :words1', 'OR');
//            $criteria->addCondition('teacher.last_name = :words3 AND teacher.first_name = :words2 AND teacher.patronymic = :words1', 'OR');
//            $criteria->addCondition('teacher.last_name = :words3 AND teacher.first_name = :words1 AND teacher.patronymic = :words2', 'OR');
            $criteria->params['words1'] = $words[0];
            $criteria->params['words2'] = $words[1];
//            $criteria->params['words3'] = $words[2];
            $isFilter = true;
        }

        if($time){
            $criteria->addCondition('time.time_begin = :time');
            $criteria->params['time'] = $time;
            $isFilter = true;
        }

        $criteria->addCondition('date.number_year = :numberYear AND date.number_week = :numberWeek');
        $criteria->params['numberWeek'] = date('W');
        $criteria->params['numberYear'] = date('Y');

        $models = TimetableLesson::model()->findAll($criteria);

        $listTime = LessonTime::model()->getListTime();

        $categories = [];
        if(count($models) > 0){
            $categoryModel = $models[0]->lesson->category;
            $categories[$categoryModel->slug] = $categoryModel;
            foreach($models as $model){
                $categoryModel = $model->lesson->category;
                if(!isset($categories[$categoryModel->slug])){
                    $categories[$categoryModel->slug] = $categoryModel;
                }
            }
        }

        $categoryModel = '';
        if (\Yii::app()->hasModule('category')) {
            $categoryModel = \Category::model()->findByAttributes(['slug' => 'stranica-raspisanie']);
        }

        $listDaysWeek = $this->_getListDaysWeek();

        $this->render('index', [
            'categoryModel' => $categoryModel,
            'categories'    => $categories,
            'listTime'      => $listTime,
            'isFilter'      => $isFilter,
            'listDaysWeek'  => $listDaysWeek,
            'models'        => $models,
        ]);
    }

    private function _getListDaysWeek($time = false){

        if(!$time){
            $time = time();
        }

        $currentNumberDayWeek = date('N', $time);
        $countDaysInCurrentMonth = date('t', $time);

        $currentDate = date('j', $time);
        $currentMonth = date('n', $time);
        $currentYear = date('Y', $time);

        $days = [];
        $i = 1;
        for($i >= 1; $i <= 7; $i++){

            $numberYear = $currentYear;
            $numberMonth = $currentMonth;
            $date = $currentDate;

            $diff = ($currentNumberDayWeek - $i);
            if($diff < 0){
                if( ($currentDate - $diff) > $countDaysInCurrentMonth ){
                    if($currentMonth < 12){
                        $numberMonth++;
                        $date = ($currentDate - $diff) - $countDaysInCurrentMonth;
                    }else{
                        $numberMonth = 1;
                        $numberYear++;
                    }
                }else{
                    $date = $date - $diff;
                }
            }else{
                if( ($currentDate - $diff) < 1 ){
                    if($currentMonth > 1){
                        $numberMonth--;
                        $newCountDaysInMonth = date('t', strtotime('01.'. $numberMonth .'.'. $numberYear));
                        $date = $newCountDaysInMonth + (($currentDate - $diff));
                    }else{
                        $numberMonth = 12;
                        $numberYear--;
                        $date = date('t', strtotime('01.'. $numberMonth .'.'. $numberYear)) + (($currentDate - $diff) + 1);
                    }
                }else{
                    $date = $date - $diff;
                }
            }

            $numberDate = $date < 10 ? '0'. $date: $date;
            $days[$i]['date'] = $numberMonth < 10 ? $numberDate  .'.'. '0'.$numberMonth .'.'. $numberYear : $date .'.'. $numberMonth .'.'. $numberYear;
            $days[$i]['full']['dayWeek'] = Timetable::model()->getNameDayWeek($i);
            $days[$i]['full']['dayAndMonth'] = $date .' '. Timetable::model()->getNameMonth($numberMonth);
            $days[$i]['short']['dayWeek'] = Timetable::model()->getNameDayWeek($i, false);
            $days[$i]['short']['dayAndMonth'] = $numberMonth < 10 ? $date .'.'. '0'.$numberMonth : $date .'.'. $numberMonth;

        }

        return $days;
    }

    public function actionShow($slug){

        $model = Lesson::model()->findByAttributes(['slug' => $slug]);

        $this->render('show', [
                'model' => $model,
            ]
        );
    }

}
