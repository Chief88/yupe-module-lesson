<?php
    $this->breadcrumbs = [
        Yii::t($this->aliasModule, 'Lessons') => [$this->patchBackend.'index'],
        $model->name,
        Yii::t($this->aliasModule, 'Edit'),
    ];

    $this->pageTitle = Yii::t($this->aliasModule, 'Lessons - edit');

    $this->menu = [
        [
            'icon' => 'list-alt',
            'label' => Yii::t($this->aliasModule, 'Management lessons'),
            'url' => [$this->patchBackend.'index']
        ],
        [
            'icon' => 'plus-sign',
            'label' => Yii::t($this->aliasModule, 'Add lesson'),
            'url' => [$this->patchBackend.'create']
        ],
        [
            'label' => Yii::t($this->aliasModule, 'Lesson') . ' «' . mb_substr($model->name, 0, 32) . '»'
        ],
        [
            'icon' => 'trash',
            'label' => Yii::t($this->aliasModule, 'Lesson delete'),
            'url' => '#', 'linkOptions' => [
                'submit' => [
                    $this->patchBackend.'delete',
                    'id' => $model->id
                ],
                'params' => [
                    Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken
                ],
                'confirm' => Yii::t($this->aliasModule, 'Do you really want to remove the lesson?'),
                'csrf' => true,
            ]
        ],
    ];
?>
<div class="page-header">
    <h1>
        <?= Yii::t($this->aliasModule, 'Lessons edit'); ?><br />
        <small>&laquo;<?= $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php
    $this->renderPartial('_form', [
        'model'         => $model,
        'aliasModule'   => $this->aliasModule,
    ]);