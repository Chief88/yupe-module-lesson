<?php
$this->breadcrumbs = [
    Yii::t($this->aliasModule, 'Lessons') => ['/lesson/lessonBackend/index'],
    Yii::t($this->aliasModule, 'Timetable'),
    Yii::t($this->aliasModule, 'List'),
];

$this->pageTitle = Yii::t($this->aliasModule, 'Timetable lessons');

$this->menu = [
    [
        'label' => Yii::t($this->aliasModule, 'Lessons'),
        'items' => [
            ['icon' => 'list-alt',
                'label' => Yii::t($this->aliasModule, 'Management lessons'),
                'url' => ['/lesson/lessonBackend/index']
            ],
        ]
    ],
    [
        'label' => Yii::t($this->aliasModule, 'Type lesson'),
        'items' => [
            [
                'icon' => 'list-alt',
                'label' => Yii::t($this->aliasModule, 'Management types'),
                'url' => ['/lesson/lessonTypeBackend/index']
            ],
        ]
    ],
    [
        'label' => Yii::t($this->aliasModule, 'Time lesson'),
        'items' => [
            [
                'icon' => 'list-alt',
                'label' => Yii::t($this->aliasModule, 'Management time'),
                'url' => ['/lesson/lessonTimeBackend/index']
            ],
        ]
    ],
    [
        'label' => Yii::t($this->aliasModule, 'Timetable'),
        'items' => [
            [
                'icon' => 'list-alt',
                'label' => Yii::t($this->aliasModule, 'Management timetable'),
                'url' => [$this->patchBackend.'index']
            ],
            ['icon' => 'plus-sign',
                'label' => Yii::t($this->aliasModule, 'Add day'),
                'url' => [$this->patchBackend.'create']
            ],
        ]
    ],
];
?>

<div class="page-header">
    <h1>
        <?= Yii::t($this->aliasModule, 'Timetable'); ?>
        <small><?= Yii::t($this->aliasModule, 'management'); ?></small>
    </h1>
</div>

<?php $this->widget('yupe\widgets\CustomGridView', [
    'hideBulkActions'   => true,
    'template'          => "<div style='position: relative; min-height: 60px;'>{pager}</div>{summary}{multiaction}\n{items}\n{extendedSummary}\n{pager}<div class='pull-right' style='margin: 26px 0;'>{headline}</div>",
    'id'                => 'timetable-grid',
    'dataProvider'      => $model->search(),
    'filter'            => $model,
    'sortField'         => 'id',
    'columns'           => [
        [
            'name'        => 'id',
            'htmlOptions' => ['style' => 'width:20px'],
            'type'        => 'raw',
            'value'       => 'CHtml::link($data->id, ["'. $this->patchBackend .'update", "id" => $data->date->id])'
        ],
        [
            'name'   => 'date_id',
            'value'  => '$data->getLessonDate()',
            'filter' => CHtml::activeDropDownList($model, 'date_id',
                Timetable::model()->getListDate(),
                ['class' => 'form-control', 'encode' => false, 'empty' => '']
            )
        ],
        [
            'class'   => 'yupe\widgets\EditableStatusColumn',
            'name'    => 'time_id',
            'url'     => $this->createUrl($this->patchBackend .'inline'),
            'source'  => LessonTime::model()->getListTime(),
            'filter' => CHtml::activeDropDownList($model, 'time_id',
                LessonTime::model()->getListTime(),
                ['class' => 'form-control', 'encode' => false, 'empty' => '']
            ),
        ],
        [
            'class'   => 'yupe\widgets\EditableStatusColumn',
            'name'    => 'lesson_id',
            'url'     => $this->createUrl($this->patchBackend .'inline'),
            'source'  => Lesson::model()->getListLesson(),
            'filter' => CHtml::activeDropDownList($model, 'lesson_id',
                Lesson::model()->getListLesson(),
                ['class' => 'form-control', 'encode' => false, 'empty' => '']
            ),
        ],
        [
            'class'   => 'yupe\widgets\EditableStatusColumn',
            'name'    => 'staff_id',
            'url'     => $this->createUrl($this->patchBackend .'inline'),
            'source'  => Staff::model()->getListStaff(),
            'filter' => CHtml::activeDropDownList($model, 'staff_id',
                Staff::model()->getListStaff(),
                ['class' => 'form-control', 'encode' => false, 'empty' => '']
            ),
        ],
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template'    => '{update}{delete}',
            'buttons'  => [
                'update' => [
                    'url'     => 'Yii::app()->createUrl("/lesson/timetableBackend/update", ["id"=>$data->date->id])',
                ],
                'delete' => [
                    'url'     => 'Yii::app()->createUrl("/lesson/timetableBackend/deleteLesson", ["id"=>$data->id])',
                ],
            ]
        ],
    ],
]); ?>