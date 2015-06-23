<?php

/**
 * Class TimetableLesson
 */
class TimetableLesson extends yupe\models\YModel{

    private $_aliasModule = 'LessonModule.lesson';

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{lesson_timetable_lesson}}';
    }

    /**
     * Returns the static model of the specified AR class.
     *
     * @return User the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'date_id'       => Yii::t($this->_aliasModule, 'Date'),
            'time_id'       => Yii::t($this->_aliasModule, 'Time'),
            'lesson_id'     => Yii::t($this->_aliasModule, 'Lesson'),
            'staff_id'      => Yii::t($this->_aliasModule, 'Teacher'),
        ];
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['date_id', 'required'],
            ['date_id, lesson_id, time_id, staff_id', 'numerical', 'integerOnly' => true, 'on'=>'integer'],
            ['date_id, lesson_id, time_id, staff_id', 'safe'],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'lesson'    => [self::BELONGS_TO, 'Lesson', 'lesson_id'],
            'time'      => [self::BELONGS_TO, 'LessonTime', 'time_id'],
            'teacher'   => [self::BELONGS_TO, 'Staff', 'staff_id'],
            'date'      => [self::BELONGS_TO, 'Timetable', 'date_id'],
        ];
    }

    public function search()
    {
        $criteria = new CDbCriteria();
        $criteria->with[] = 'date';
        $criteria->compare('t.id', $this->id);
        $criteria->compare('date.date', $this->date_id, true);
        $criteria->compare('t.lesson_id', $this->lesson_id);
        $criteria->compare('t.staff_id', $this->staff_id);
        $criteria->compare('t.time_id', $this->time_id);

        return new CActiveDataProvider(get_class($this), [
            'criteria' => $criteria,
            'sort'     => ['defaultOrder' => 't.date_id']
        ]);
    }

    public function getLessonName(){
        return empty($this->lesson) ? '---' : $this->lesson->name;
    }

    public function getLessonTime(){
        return empty($this->time) ? '---' : $this->time->time_begin;
    }

    public function getLessonDate(){
        return empty($this->date) ? '---' : $this->date->date;
    }

    public function getTeacherFio(){
        return empty($this->teacher) ? '---' : $this->teacher->fio;
    }

}