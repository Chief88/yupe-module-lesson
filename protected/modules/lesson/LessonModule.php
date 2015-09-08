<?php

use yupe\components\WebModule;

class LessonModule extends WebModule
{
    const VERSION = '0.9.6';

    public $uploadPath = 'lesson';
    public $allowedExtensions = 'jpg,jpeg,png,gif';
    public $minSize = 0;
    public $maxSize = 5368709120;
    public $maxFiles = 1;
    public $perPage = 10;

    public  $aliasModule = 'LessonModule.lesson';
    public  $patchBackend = '/lesson/lessonBackend/';

    public function getDependencies()
    {
        return [
            'category',
            'staff',
        ];
    }

    public function getInstall()
    {
        if (parent::getInstall()) {
            @mkdir(Yii::app()->uploadManager->getBasePath() . DIRECTORY_SEPARATOR . $this->uploadPath, 0755);
        }

        return false;
    }

    public function getParamsLabels()
    {
        return [
            'mainCategory'      => Yii::t($this->aliasModule, 'Main category'),
            'adminMenuOrder'    => Yii::t($this->aliasModule, 'Menu items order')
        ];
    }

    public function getEditableParams()
    {
        return [
            'adminMenuOrder',
            'mainCategory' => CHtml::listData($this->getCategoryList(), 'id', 'name'),
        ];
    }

    public function getEditableParamsGroups()
    {
        return [
            'main'   => [
                'label' => Yii::t($this->aliasModule, 'General module settings'),
                'items' => [
                    'adminMenuOrder',
                    'mainCategory'
                ]
            ],
        ];
    }

    public function getVersion()
    {
        return self::VERSION;
    }

    public function getIsInstallDefault()
    {
        return true;
    }

    public function getCategory()
    {
        return Yii::t($this->aliasModule, 'Content');
    }

    public function getName()
    {
        return Yii::t($this->aliasModule, 'Lessons');
    }

    public function getDescription()
    {
        return Yii::t($this->aliasModule, 'Module for creating and management lessons');
    }

    public function getAuthor()
    {
        return Yii::t($this->aliasModule, 'Chief88');
    }

    public function getAuthorEmail()
    {
        return Yii::t($this->aliasModule, 'serg.latyshkov@gmail.com');
    }

    public function getUrl(){
        return 'https://github.com/Chief88/yupe-module-lesson';
    }

    public function getIcon()
    {
        return "fa fa-fw fa-graduation-cap";
    }

    public function getAdminPageLink()
    {
        return $this->patchBackend .'index';
    }

    public function getNavigation()
    {
        return [
            [
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t($this->aliasModule, 'Lessons list'),
                'url'   => [$this->patchBackend.'index']
            ],
            [
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t($this->aliasModule, 'Create lesson'),
                'url'   => [$this->patchBackend.'create']
            ],
        ];
    }

    public function init()
    {
        parent::init();

        $this->setImport(
            [
                'lesson.models.*'
            ]
        );
    }

    public function getAuthItems()
    {
        return [
            [
                'name'        => 'Lesson.LessonManager',
                'description' => Yii::t($this->aliasModule, 'Manage lessons'),
                'type'        => AuthItem::TYPE_TASK,
                'items'       => [
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'lesson.lessonBackend.Create',
                        'description' => Yii::t($this->aliasModule, 'Creating lessons')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'lesson.lessonBackend.Delete',
                        'description' => Yii::t($this->aliasModule, 'Removing lessons')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'lesson.lessonBackend.Index',
                        'description' => Yii::t($this->aliasModule, 'List of lessons')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'lesson.lessonBackend.Update',
                        'description' => Yii::t($this->aliasModule, 'Editing lessons')
                    ],
                ]
            ],
            [
                'name'        => 'Lesson.LessonTypeManager',
                'description' => Yii::t($this->aliasModule, 'Manage lessons type'),
                'type'        => AuthItem::TYPE_TASK,
                'items'       => [
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'lesson.lessonTypeBackend.Create',
                        'description' => Yii::t($this->aliasModule, 'Creating type lessons')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'lesson.lessonTypeBackend.Delete',
                        'description' => Yii::t($this->aliasModule, 'Removing type lessons')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'lesson.lessonTypeBackend.Index',
                        'description' => Yii::t($this->aliasModule, 'List of types lessons')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'lesson.lessonTypeBackend.Update',
                        'description' => Yii::t($this->aliasModule, 'Editing type lessons')
                    ],
                ]
            ],
            [
                'name'        => 'Lesson.LessonTimeManager',
                'description' => Yii::t($this->aliasModule, 'Manage lessons time'),
                'type'        => AuthItem::TYPE_TASK,
                'items'       => [
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'lesson.lessonTimeBackend.Create',
                        'description' => Yii::t($this->aliasModule, 'Creating time lessons')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'lesson.lessonTimeBackend.Delete',
                        'description' => Yii::t($this->aliasModule, 'Removing time lessons')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'lesson.lessonTimeBackend.Index',
                        'description' => Yii::t($this->aliasModule, 'List of time lessons')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'lesson.lessonTimeBackend.Update',
                        'description' => Yii::t($this->aliasModule, 'Editing time lessons')
                    ],
                ]
            ],
            [
                'name'        => 'Lesson.TimetableManager',
                'description' => Yii::t($this->aliasModule, 'Manage lessons timetable'),
                'type'        => AuthItem::TYPE_TASK,
                'items'       => [
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'lesson.timetableBackend.Create',
                        'description' => Yii::t($this->aliasModule, 'Creating timetable lessons')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'lesson.timetableBackend.Delete',
                        'description' => Yii::t($this->aliasModule, 'Removing timetable lessons')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'lesson.timetableBackend.Index',
                        'description' => Yii::t($this->aliasModule, 'List of timetable lessons')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'lesson.timetableBackend.Update',
                        'description' => Yii::t($this->aliasModule, 'Editing timetable lessons')
                    ],
                ]
            ],
        ];
    }

}
