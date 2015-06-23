<? $form = $this->beginWidget(
    '\yupe\widgets\ActiveForm', [
        'id'                     => 'lesson-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => ['class' => 'well', 'enctype' => 'multipart/form-data'],
    ]
); ?>

<?= $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-3">
        <?= $form->dropDownListGroup(
            $model,
            'type_id',
            [
                'widgetOptions' => [
                    'data'        => LessonType::model()->getListNameType(),
                    'htmlOptions' => [
                        'empty'  => '--Выбрать--',
                        'encode' => false
                    ],
                ],
            ]
        ); ?>
    </div>

    <div class="col-sm-3">
        <?= $form->dropDownListGroup(
            $model,
            'category_id',
            [
                'widgetOptions' => [
                    'data'          => Category::model()->getFormattedList(
                        (int)Yii::app()->getModule('lesson')->mainCategory
                    ),
                    'htmlOptions'   => [
                        'empty'  => Yii::t($aliasModule, '--choose--'),
                        'encode' => false
                    ],
                ],
            ]
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-7">
        <?= $form->textFieldGroup($model, 'name'); ?>

        <?= $form->slugFieldGroup($model, 'slug', ['sourceAttribute' => 'name']); ?>
    </div>

    <div class="col-sm-5">
        <?php $styleImage = !$model->isNewRecord && $model->image ? '' : ' display:none;' ?>
        <?= CHtml::image(
            !$model->isNewRecord && $model->image ? $model->getImageUrl() : '#',
            $model->name,
            [
                'class' => 'preview-image',
                'style' => 'max-width: 100%;'. $styleImage,
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
    <div class="col-sm-12 <?= $model->hasErrors('description') ? 'has-error' : ''; ?>">
        <?= $form->labelEx($model, 'description'); ?>
        <?php $this->widget(
            $this->module->getVisualEditor(),
            [
                'model'     => $model,
                'attribute' => 'description',
            ]
        ); ?>
        <?= $form->error($model, 'description'); ?>
    </div>
</div>

<!--<div class="row">-->
<!--    <div class="col-sm-3">-->
<!--        --><?//= $form->dropDownListGroup(
//            $model,
//            'staff_id',
//            [
//                'widgetOptions' => [
//                    'data'        => Staff::model()->getListStaff(),
//                    'htmlOptions' => [
//                        'empty'  => '--Выбрать--',
//                        'encode' => false
//                    ],
//                ],
//            ]
//        ); ?>
<!--    </div>-->
<!---->
<!--    <div class="col-sm-3">-->
<!--        --><?//= $form->select2Group(
//            $model,
//            'time_id',
//            [
//                'widgetOptions' => [
//                    'data'        => LessonTime::model()->getListTime(),
//                    'htmlOptions' => [
//                        'empty'  => '--Выбрать--',
//                        'encode' => false,
//                        'multiple' => 'multiple',
//                    ],
//                ],
//            ]
//        ); ?>
<!--    </div>-->
<!---->
<!--    <div class="col-sm-3">-->
<!--        --><?php //echo $form->datePickerGroup(
//            $model,
//            'date',
//            [
//                'widgetOptions' => [
//                    'options' => [
//                        'format'    => 'dd-mm-yyyy',
//                        'weekStart' => 1,
//                        'multidate' => true,
//                        'multidateSeparator' => ', ',
////                        'autoclose' => true,
//                    ],
//                ],
//                'prepend'       => '<i class="fa fa-calendar"></i>',
//            ]
//        );
//        ?>
<!--    </div>-->
<!--</div>-->

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
        'htmlOptions' => ['name' => 'submit-type', 'value' => 'index'],
        'label'       => $model->isNewRecord ? 'Создать и закрыть' : 'Сохранить и закрыть',
    ]
); ?>

<?php $this->endWidget(); ?>