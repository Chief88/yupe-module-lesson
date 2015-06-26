<?php
$this->breadcrumbs = [
    Yii::t($this->aliasModule, 'Lessons') => ['/lesson/lessonBackend/index'],
    Yii::t($this->aliasModule, 'Timetable') => [$this->patchBackend.'index'],
    Yii::t($this->aliasModule, 'List'),
];

$this->pageTitle = Yii::t($this->aliasModule, 'Add day');

$this->menu = [
    [
        'icon' => 'list-alt', 'label' => Yii::t($this->aliasModule, 'Management timetable'),
        'url' => [$this->patchBackend.'index']
    ],
];
?>

<div class="page-header">
    <h1>
        <?= Yii::t($this->aliasModule, 'Timetable'); ?>
        <small><?= Yii::t($this->aliasModule, 'create'); ?></small>
    </h1>
</div>

<?php
$this->renderPartial('_form', [
    'model'         => $model,
    'aliasModule'   => $this->aliasModule,
]);