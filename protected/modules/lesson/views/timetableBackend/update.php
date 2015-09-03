<?php
$this->breadcrumbs = [
    Yii::t($this->aliasModule, 'Lessons') => ['/lesson/lessonBackend/index'],
    Yii::t($this->aliasModule, 'Timetable') => [$this->patchBackend.'index'],
    Yii::t($this->aliasModule, 'Update'),
];

    $this->pageTitle = Yii::t($this->aliasModule, 'Timetable - edit');

    $this->menu = [
        [
            'icon' => 'list-alt',
            'label' => Yii::t($this->aliasModule, 'Management timetable'),
            'url' => [$this->patchBackend.'index']
        ],
        [
            'icon' => 'plus-sign',
            'label' => Yii::t($this->aliasModule, 'Add day'),
            'url' => [$this->patchBackend.'create']
        ],
        [
            'label' => Yii::t($this->aliasModule, 'Date') . ' «' . mb_substr($model->date, 0, 32) . '»'
        ],
        [
            'icon' => 'trash',
            'label' => Yii::t($this->aliasModule, 'Date delete'),
            'url' => '#', 'linkOptions' => [
                'submit' => [
                    $this->patchBackend.'delete',
                    'id' => $model->id
                ],
                'params' => [
                    Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken
                ],
                'confirm' => Yii::t($this->aliasModule, 'Do you really want to remove the date?'),
                'csrf' => true,
            ]
        ],
    ];
?>
<div class="page-header">
    <h1>
        <?= Yii::t($this->aliasModule, 'Timetable edit'); ?><br />
        <small>&laquo;<?= $model->date; ?>&raquo;</small>
    </h1>
</div>

<?php
    $this->renderPartial('_form', [
        'model'         => $model,
        'aliasModule'   => $this->aliasModule,
    ]);