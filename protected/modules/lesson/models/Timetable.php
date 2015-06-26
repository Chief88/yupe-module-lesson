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
            'date'              => Yii::t($this->_aliasModule, 'Date'),
            'number_year'       => Yii::t($this->_aliasModule, 'Number year'),
            'number_month'      => Yii::t($this->_aliasModule, 'Number month'),
            'number_week'       => Yii::t($this->_aliasModule, 'Number week'),
            'number_day_week'   => Yii::t($this->_aliasModule, 'Number day week'),
        ];
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['date, number_year, number_month, number_week, number_day_week', 'required'],
            ['date', 'filter', 'filter' => 'trim'],
            ['date', 'length', 'max' => 250],
            ['date', 'unique'],
            ['number_year, number_month, number_week, number_day_week', 'numerical', 'integerOnly' => true, 'on'=>'integer'],
            ['date, number_year, number_month, number_week, number_day_week', 'safe'],
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

    public function beforeValidate(){
        if(!empty($this->date)){
            $timeForCurrentModel = strtotime($this->date);
            $this->number_year = date('Y', $timeForCurrentModel);
            $this->number_month = date('n', $timeForCurrentModel);
            $this->number_week = date('W', $timeForCurrentModel);
            $this->number_day_week = date('N', $timeForCurrentModel);
        }

        return parent::beforeValidate();
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

    public function getListMonth(){
        return [
            1   => Yii::t($this->_aliasModule, 'January'),
            2   => Yii::t($this->_aliasModule, 'February'),
            3   => Yii::t($this->_aliasModule, 'March'),
            4   => Yii::t($this->_aliasModule, 'April'),
            5   => Yii::t($this->_aliasModule, 'May'),
            6   => Yii::t($this->_aliasModule, 'June'),
            7   => Yii::t($this->_aliasModule, 'July'),
            8   => Yii::t($this->_aliasModule, 'Augustus'),
            9   => Yii::t($this->_aliasModule, 'September'),
            10  => Yii::t($this->_aliasModule, 'October'),
            11  => Yii::t($this->_aliasModule, 'November'),
            12  => Yii::t($this->_aliasModule, 'December'),
        ];
    }

    public function getNameMonth($number = false){
        $listMonth = $this->getListMonth();

        if($number){
            return isset($listMonth[$number]) ? $listMonth[$number] : '---';
        }
        return isset($listMonth[$this->number_month]) ? $listMonth[$this->number_month] : '---';
    }

    public function getListDaysWeek(){
        return [
            1   => [
                'full'  => Yii::t($this->_aliasModule, 'Monday'),
                'short' => Yii::t($this->_aliasModule, 'Md'),
            ],
            2   => [
                'full'  => Yii::t($this->_aliasModule, 'Tuesday'),
                'short' => Yii::t($this->_aliasModule, 'Td'),
            ],
            3   => [
                'full'  => Yii::t($this->_aliasModule, 'Wednesday'),
                'short' => Yii::t($this->_aliasModule, 'Wd'),
            ],
            4   => [
                'full'  => Yii::t($this->_aliasModule, 'Thursday'),
                'short' => Yii::t($this->_aliasModule, 'Trd'),
            ],
            5   => [
                'full'  => Yii::t($this->_aliasModule, 'Friday'),
                'short' => Yii::t($this->_aliasModule, 'Fd'),
            ],
            6   => [
                'full'  => Yii::t($this->_aliasModule, 'Saturday'),
                'short' => Yii::t($this->_aliasModule, 'St'),
            ],
            7   => [
                'full'  => Yii::t($this->_aliasModule, 'Sunday'),
                'short' => Yii::t($this->_aliasModule, 'Su'),
            ],
        ];
    }

    public function getNameDayWeek($number = false, $full = true){
        $listDays = $this->getListDaysWeek();
        if(!$number){
            $number = $this->number_day_week;
        }

        if($full){
            return isset($listDays[$number]) ? $listDays[$number]['full'] : '---';
        }
        return isset($listDays[$number]) ? $listDays[$number]['short'] : '---';
    }

}