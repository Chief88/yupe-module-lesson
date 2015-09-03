<?php

/**
 * Class Lesson
 */
class Lesson extends yupe\models\YModel{

    private $_aliasModule = 'LessonModule.lesson';

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{lesson_lesson}}';
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
            'name'          => Yii::t($this->_aliasModule, 'Name'),
            'description'   => Yii::t($this->_aliasModule, 'Description'),
            'date'          => Yii::t($this->_aliasModule, 'Date'),
            'type_id'       => Yii::t($this->_aliasModule, 'Lesson type'),
            'category_id'   => Yii::t($this->_aliasModule, 'Category'),
            'time_id'       => Yii::t($this->_aliasModule, 'Time'),
            'staff_id'      => Yii::t($this->_aliasModule, 'Teacher'),
            'image'         => Yii::t($this->_aliasModule, 'Image'),
            'hall'          => Yii::t($this->_aliasModule, 'Hall'),
            'slug'          => Yii::t($this->_aliasModule, 'Alias'),

        ];
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['name, description, slug, category_id', 'required'],
            ['name, hall, slug, description', 'filter', 'filter' => 'trim'],
            ['name, image, hall, slug', 'length', 'max' => 250],
            ['slug', 'unique'],
            ['type_id, time_id, staff_id, category_id', 'numerical', 'integerOnly' => true, 'on'=>'integer'],
            ['name, description, date, type_id, category_id, time_id, staff_id, image, hall, slug', 'safe'],
        ];
    }

    public function behaviors()
    {
        $module = Yii::app()->getModule('lesson');

        return [
            'imageUpload' => [
                'class'         => 'yupe\components\behaviors\ImageUploadBehavior',
                'attributeName' => 'image',
                'uploadPath'    => $module->uploadPath,
                'resizeOptions' => [
                    'width'   => 9999,
                    'height'  => 9999,
                    'quality' => [
                        'jpegQuality'         => 100,
                        'pngCompressionLevel' => 10
                    ],
                ],
                'defaultImage'   => $module->getAssetsUrl() . '/img/nophoto.jpg',
            ],
        ];
    }

    public function beforeValidate()
    {
        if (!$this->slug) {
            $this->slug = yupe\helpers\YText::translit($this->name);
        }

        return parent::beforeValidate();
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'category'          => [self::BELONGS_TO, 'Category', 'category_id'],
            'type'              => [self::BELONGS_TO, 'LessonType', 'type_id'],
            'time'              => [self::BELONGS_TO, 'LessonTime', 'time_id'],
            'teacher'           => [self::BELONGS_TO, 'Staff', 'staff_id'],
            'timetableLesson'   => [self::HAS_MANY, 'TimetableLesson', 'lesson_id'],
        ];
    }

    public function search()
    {
        $criteria = new CDbCriteria();

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('type_id', $this->type_id);
        $criteria->compare('category_id', $this->category_id);
        $criteria->compare('time_id', $this->time_id);

        return new CActiveDataProvider(get_class($this), [
            'criteria' => $criteria,
            'sort'     => ['defaultOrder' => 't.id DESC']
        ]);
    }

    public function category($category_id){

        $this->getDbCriteria()->mergeWith(
            [
                'condition' => 'category_id = :category_id',
                'params'    => [':category_id' => $category_id],
            ]
        );

        return $this;
    }

    public function getCategoryName()
    {
        return ($this->category === null) ? '---' : $this->category->name;
    }

    public function getLessonTypeName(){

        return empty($this->type) ? '---' : $this->type->name;
    }

    public function getListLesson(){
        return CHtml::listData($this->model()->findAll(), 'id', 'name');
    }

} 