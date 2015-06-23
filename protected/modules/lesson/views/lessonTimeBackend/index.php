<?php
$this->breadcrumbs = [
    Yii::t($this->aliasModule, 'Lessons') => ['/lesson/lessonBackend/index'],
    Yii::t($this->aliasModule, 'Time') => [$this->patchBackend.'index'],
    Yii::t($this->aliasModule, 'List'),
];

$this->pageTitle = Yii::t($this->aliasModule, 'List time lessons');

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
                'url' => ['index']
            ],
            ['icon' => 'plus-sign',
                'label' => Yii::t($this->aliasModule, 'Add time'),
                'url' => [$this->patchBackend .'create']
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
            <?= Yii::t($this->aliasModule, 'Time lessons'); ?>
            <small><?= Yii::t($this->aliasModule, 'management'); ?></small>
        </h1>
    </div>

<?php $this->widget('yupe\widgets\CustomGridView', [
    'id'                => 'timeLesson-grid',
    'sortableRows'      => true,
    'sortableAjaxSave'  => true,
    'sortableAttribute' => 'sort',
    'sortableAction'    => $this->patchBackend .'sortable',
    'dataProvider'      => $model->search(),
    'filter'            => $model,
    'columns'           => [
        [
            'name'        => 'id',
            'htmlOptions' => ['style' => 'width:20px'],
            'type'        => 'raw',
            'value'       => 'CHtml::link($data->id, ["'. $this->patchBackend .'update", "id" => $data->id])'
        ],
        [
            'class'    => 'bootstrap.widgets.TbEditableColumn',
            'name'     => 'time_begin',
            'editable' => [
                'url'    => $this->createUrl($this->patchBackend .'inline'),
                'mode'   => 'inline',
                'params' => [
                    Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                ]
            ],
            'filter'   => CHtml::activeTextField($model, 'time_begin', ['class' => 'form-control']),
        ],
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template'    => '{update}{delete}',
        ],
    ],
]); ?>