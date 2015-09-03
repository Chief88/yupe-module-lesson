<? $form = $this->beginWidget(
    '\yupe\widgets\ActiveForm', [
    'id'                     => 'typeLesson-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'type'                   => 'vertical',
    'htmlOptions'            => [
        'class'     => 'well',
        'enctype'   => 'multipart/form-data'
    ],
]
); ?>
<?= $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-7">
        <?= $form->textFieldGroup($model, 'name'); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-7">
        <?= $form->slugFieldGroup($model, 'slug', ['sourceAttribute' => 'name']); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-7">
        <?= CHtml::image(
            !$model->isNewRecord && $model->image ? $model->getImageUrl() : '#',
            $model->name,
            [
                'class' => 'preview-image',
                'style' => !$model->isNewRecord && $model->image ? 'max-width: 100%;' : 'display:none; max-width: 100%;'
            ]
        ); ?>

        <?php if (!$model->isNewRecord && $model->image): ?>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="delete-file"> <?= Yii::t('YupeModule.yupe', 'Delete the file') ?>
                </label>
            </div>
        <?php endif; ?>

        <?= $form->fileFieldGroup(
            $model,
            'image',
            [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'onchange' => 'readURL(this);',
                        'style'    => 'background-color: inherit;'
                    ]
                ]
            ]
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 <?php echo $model->hasErrors('description') ? 'has-error' : ''; ?>">
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php $this->widget(
            $this->module->getVisualEditor(),
            [
                'model'     => $model,
                'attribute' => 'description',
            ]
        ); ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>
</div>

<br/>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'context'    => 'primary',
        'label'      => $model->isNewRecord ? 'Создать и продолжить' : 'Сохранить и продолжить',
    ]
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType'  => 'submit',
        'htmlOptions' => [
            'name' => 'submit-type',
            'value' => 'index'
        ],
        'label'       => $model->isNewRecord ? 'Создать и закрыть' : 'Сохранить и закрыть',
    ]
); ?>

<?php $this->endWidget(); ?>
