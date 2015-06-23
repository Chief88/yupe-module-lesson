<?php

/**
 * Class Timetable
 */
class Timetable extends yupe\models\YModel{

    private $_aliasModule = 'LessonModule.lesson';

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{lesson_timetable}}';
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
            'date'          => Yii::t($this->_aliasModule, 'Date'),
        ];
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['date', 'required'],
            ['date', 'filter', 'filter' => 'trim'],
            ['date', 'length', 'max' => 250],
            ['date', 'safe'],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'timetableLesson'   => [self::HAS_MANY, 'TimetableLesson', 'date_id'],
        ];
    }

    public function beforeDelete(){
        foreach ($this->timetableLesson as $timetableLesson) {
            $timetableLesson->delete();
        }

        return parent::beforeDelete();
    }

    public function search()
    {
        $criteria = new CDbCriteria();

        $criteria->compare('id', $this->id);
        $criteria->compare('date', $this->date, true);

        return new CActiveDataProvider(get_class($this), [
            'criteria' => $criteria,
            'sort'     => ['defaultOrder' => 't.date']
        ]);
    }

    public function getListDate(){
        return CHtml::listData($this->model()->findAll(), 'id', 'date');
    }

}