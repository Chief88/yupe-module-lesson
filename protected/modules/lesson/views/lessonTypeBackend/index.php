<?php
$this->breadcrumbs = [
    Yii::t($this->aliasModule, 'Lessons') => ['/lesson/lessonBackend/index'],
    Yii::t($this->aliasModule, 'Types') => [$this->patchBackend.'index'],
    Yii::t($this->aliasModule, 'List'),
];

$this->pageTitle = Yii::t($this->aliasModule, 'List type lessons');

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
                'url' => [$this->patchBackend .'index']
            ],
            ['icon' => 'plus-sign',
                'label' => Yii::t($this->aliasModule, 'Add type'),
                'url' => [$this->patchBackend .'create']
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
            <?= Yii::t($this->aliasModule, 'Types lessons'); ?>
            <small><?= Yii::t($this->aliasModule, 'management'); ?></small>
        </h1>
    </div>

<?php $this->widget('yupe\widgets\CustomGridView', [
    'id'           => 'typeLesson-grid',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'sortField'    => 'id',
    'columns'      => [
        [
            'name'        => 'id',
            'htmlOptions' => ['style' => 'width:20px'],
            'type'        => 'raw',
            'value'       => 'CHtml::link($data->id, ["'. $this->patchBackend .'update", "id" => $data->id])'
        ],
        [
            'header' => Yii::t($this->aliasModule, 'Image'),
            'value'  => 'CHtml::image($data->getImageUrl(100, 100))',
            'type'   => 'raw'
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
            'class'    => 'bootstrap.widgets.TbEditableColumn',
            'name'     => 'slug',
            'editable' => [
                'url'    => $this->createUrl('/lesson/lessonTypeBackend/inline'),
                'mode'   => 'inline',
                'params' => [
                    Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                ]
            ],
            'filter'   => CHtml::activeTextField($model, 'slug', ['class' => 'form-control']),
        ],
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template'    => '{update}{delete}',
        ],
    ],
]); ?>