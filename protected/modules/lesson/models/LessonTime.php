<?php

/**
 * Class LessonTime
 */
class LessonTime extends yupe\models\YModel{

    private $_aliasModule = 'LessonModule.lesson';

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{lesson_time}}';
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
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'time_begin'  => Yii::t($this->_aliasModule, 'Time begin'),
            'sort'  => Yii::t($this->_aliasModule, 'Sort'),
        ];
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['time_begin', 'required'],
            ['time_begin', 'filter', 'filter' => 'trim'],
            ['time_begin', 'length', 'max' => 250],
            ['sort', 'numerical', 'integerOnly' => true],
            ['time_begin, sort', 'safe'],
        ];
    }

    public function behaviors()
    {
        $module = Yii::app()->getModule('lesson');

        return [
            'sortable'             => [
                'class'         => 'yupe\components\behaviors\SortableBehavior',
                'attributeName' => 'sort'
            ]
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'lesson'  => [self::BELONGS_TO, 'Lesson', 'id'],
        ];
    }

    public function search()
    {
        $criteria = new CDbCriteria();

        $criteria->compare('id', $this->id);
        $criteria->compare('time_begin', $this->time_begin, true);

        return new CActiveDataProvider(get_class($this), [
            'criteria' => $criteria,
            'sort'     => ['defaultOrder' => 't.sort']
        ]);
    }

    public function getListTime(){
        return CHtml::listData($this->model()->findAll(['order' => 'sort']), 'id', 'time_begin');
    }

}