<?php
$this->breadcrumbs = [
    Yii::t($this->aliasModule, 'Lessons') => ['/lesson/lessonBackend/index'],
    Yii::t($this->aliasModule, 'Time') => [$this->patchBackend.'index'],
    Yii::t($this->aliasModule, 'Create'),
];

$this->pageTitle = Yii::t($this->aliasModule, 'Create new time lesson');

$this->menu = [
    ['icon' => 'list-alt', 'label' => Yii::t($this->aliasModule, 'Management time'),
        'url' => [$this->patchBackend.'index']
    ],
];
?>

<div class="page-header">
    <h1>
        <?= Yii::t($this->aliasModule, 'Time lesson'); ?>
        <small><?= Yii::t($this->aliasModule, 'create'); ?></small>
    </h1>
</div>

<?php

$this->renderPartial('_form', [
    'model'         => $model,
    'aliasModule'   => $this->aliasModule,
]);