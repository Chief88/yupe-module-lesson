<?php
$this->breadcrumbs = [
    Yii::t($this->aliasModule, 'Lessons') => [$this->patchBackend.'index'],
    Yii::t($this->aliasModule, 'Create'),
];

$this->pageTitle = Yii::t($this->aliasModule, 'Create new lesson');

$this->menu = [
    [
        'icon' => 'list-alt', 'label' => Yii::t($this->aliasModule, 'Management lessons'),
        'url' => [$this->patchBackend.'index']
    ],
];
?>

<div class="page-header">
    <h1>
        <?= Yii::t($this->aliasModule, 'Lessons'); ?>
        <small><?= Yii::t($this->aliasModule, 'create'); ?></small>
    </h1>
</div>

<?php
$this->renderPartial('_form', [
    'model'         => $model,
    'aliasModule'   => $this->aliasModule,
]);