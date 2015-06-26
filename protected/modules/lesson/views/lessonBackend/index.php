<?php
$this->breadcrumbs = [
    Yii::t($this->aliasModule, 'Lessons') => [$this->patchBackend.'index'],
    Yii::t($this->aliasModule, 'List'),
];

$this->pageTitle = Yii::t($this->aliasModule, 'List lessons');

$this->menu = [
    [
        'label' => Yii::t($this->aliasModule, 'Lessons'),
        'items' => [
            ['icon' => 'list-alt',
                'label' => Yii::t($this->aliasModule, 'Management lessons'),
                'url' => [$this->patchBackend.'index']
            ],
            ['icon' => 'plus-sign',
                'label' => Yii::t($this->aliasModule, 'Add lesson'),
                'url' => [$this->patchBackend.'create']
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
                'url' => ['/lesson/timetableBackend/index']
            ],
        ]
    ],
];
?>

<div class="page-header">
    <h1>
        <?= Yii::t($this->aliasModule, 'Lessons'); ?>
        <small><?= Yii::t($this->aliasModule, 'management'); ?></small>
    </h1>
</div>

<?php $this->widget('yupe\widgets\CustomGridView', [
    'id'           => 'lesson-grid',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'sortField'    => 'id',
    'columns'      => [
        [
            'name'        => 'id',
            'htmlOptions' => ['style' => 'width:20px'],
            'type'        => 'raw',
            'value'       => 'CHtml::link($data->id, ["/lesson/lessonBackend/update", "id" => $data->id])'
        ],
        [
            'class'    => 'bootstrap.widgets.TbEditableColumn',
            'name'     => 'name',
            'editable' => [
                'url'    => $this->createUrl($this->patchBackend .'inline'),
                'mode'   => 'inline',
                'params' => [
                    Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                ]
            ],
            'filter'   => CHtml::activeTextField($model, 'name', ['class' => 'form-control']),
        ],
        [
            'class'   => 'yupe\widgets\EditableStatusColumn',
            'name'    => 'type_id',
            'url'     => $this->createUrl($this->patchBackend .'inline'),
            'source'  => LessonType::model()->getListNameType(),
            'filter' => CHtml::activeDropDownList($model, 'type_id',
                LessonType::model()->getListNameType(),
                ['class' => 'form-control', 'encode' => false, 'empty' => '']
            ),
        ],
        [
            'class'   => 'yupe\widgets\EditableStatusColumn',
            'name'    => 'category_id',
            'url'     => $this->createUrl($this->patchBackend .'inline'),
            'source'  => Category::model()->getFormattedList(Yii::app()->getModule('lesson')->mainCategory),
            'filter' => CHtml::activeDropDownList($model, 'category_id',
                Category::model()->getFormattedList(Yii::app()->getModule('lesson')->mainCategory),
                ['class' => 'form-control', 'encode' => false, 'empty' => '']
            ),
        ],
        [
            'class'    => 'bootstrap.widgets.TbEditableColumn',
            'name'     => 'hall',
            'editable' => [
                'url'    => $this->createUrl($this->patchBackend .'inline'),
                'mode'   => 'inline',
                'params' => [
                    Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                ]
            ],
            'filter'   => CHtml::activeTextField($model, 'hall', ['class' => 'form-control']),
        ],
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template'    => '{update}{delete}',
        ],
    ],
]); ?>