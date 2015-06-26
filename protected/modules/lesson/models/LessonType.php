<?php

/**
 * Class LessonType
 */
class LessonType extends yupe\models\YModel{

    private $_aliasModule = 'LessonModule.lesson';

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{lesson_type}}';
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
            'name'  => Yii::t($this->_aliasModule, 'Name'),
            'image' => Yii::t($this->_aliasModule, 'Image'),
            'slug'  => Yii::t($this->_aliasModule, 'Alias'),
        ];
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['name, slug', 'required'],
            ['name, slug', 'filter', 'filter' => 'trim'],
            ['slug', 'unique'],
            ['name, image, slug', 'length', 'max' => 250],
            ['name, image, slug', 'safe'],
        ];
    }

    public function beforeValidate()
    {
        if (!$this->slug) {
            $this->slug = yupe\helpers\YText::translit($this->name);
        }

        return parent::beforeValidate();
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
        $criteria->compare('name', $this->name, true);

        return new CActiveDataProvider(get_class($this), [
            'criteria' => $criteria,
            'sort'     => ['defaultOrder' => 't.id DESC']
        ]);
    }

    public function getListNameType(){
        return CHtml::listData(
            $this->model()->findAll(),
            'id',
            'name'
        );
    }

}