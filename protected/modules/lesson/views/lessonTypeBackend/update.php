<?php
$this->breadcrumbs = [
    Yii::t($this->aliasModule, 'Lessons') => ['/lesson/lessonBackend/index'],
    Yii::t($this->aliasModule, 'Types') => [$this->patchBackend.'index'],
    Yii::t($this->aliasModule, 'Edit'),
];

    $this->pageTitle = Yii::t($this->aliasModule, 'Type lesson - edit');

    $this->menu = [
        [
            'icon' => 'list-alt', 
            'label' => Yii::t($this->aliasModule, 'Management types'),
            'url' => [$this->patchBackend.'index']
        ],
        [
            'icon' => 'plus-sign', 
            'label' => Yii::t($this->aliasModule, 'Add type'),
            'url' => [$this->patchBackend.'create']
        ],
        [
            'label' => Yii::t($this->aliasModule, 'Type lesson') . ' «' . mb_substr($model->name, 0, 32) . '»'
        ],
        [
            'icon' => 'trash', 
            'label' => Yii::t($this->aliasModule, 'Type delete'),
            'url' => '#', 'linkOptions' => [
                'submit' => [
                    $this->patchBackend.'delete', 'id' => $model->id
                ],
                'params' => [
                    Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken
                ],
            'confirm' => Yii::t($this->aliasModule, 'Do you really want to remove the type lesson?'),
                'csrf' => true,
            ]
        ],
    ];
?>
<div class="page-header">
    <h1>
        <?= Yii::t($this->aliasModule, 'Type lesson edit'); ?><br />
        <small>&laquo;<?= $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php
    $this->renderPartial('_form', [
        'model'         => $model,
        'aliasModule'   => $this->aliasModule,
    ]);