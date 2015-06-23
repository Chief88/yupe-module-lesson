<? $form = $this->beginWidget(
    '\yupe\widgets\ActiveForm', [
    'id'                     => 'timeLesson-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'type'                   => 'vertical',
    'htmlOptions'            => [
        'class' => 'well', 
        'enctype' => 'multipart/form-data'
    ],
]
); ?>
<?= $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-7">
        <?= $form->textFieldGroup($model, 'time_begin'); ?>
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
