<?php Booster::getBooster()->registerPackage('select2'); ?>

<? $form = $this->beginWidget(
    '\yupe\widgets\ActiveForm', [
        'id'                     => 'timetable-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => ['class' => 'well', 'enctype' => 'multipart/form-data'],
    ]
); ?>

<?= $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-3">
        <?php echo $form->datePickerGroup($model, 'date', [
                'widgetOptions' => [
                    'options' => [
                        'format'    => 'dd.mm.yyyy',
                        'weekStart' => 1,
                        'autoclose' => true,
                    ],
                ],
                'prepend'       => '<i class="fa fa-calendar"></i>',
            ]
        );
        ?>
    </div>
</div>

<div class="row form-group">
    <div class="col-sm-2">
        <?= Yii::t($aliasModule, "Add lesson"); ?>
    </div>
    <div class="col-sm-2">
        <button id="button-add-lesson" type="button" class="btn btn-default"><i class="fa fa-fw fa-plus"></i>
        </button>
    </div>
</div>
<?php $timetableLessonModel = new TimetableLesson(); ?>
<div class="row">
    <div id="timetable-lesson">
        <div class="lesson-template hidden form-group">
            <div class="row">
                <div class="col-sm-3">
                    <?= $form->dropDownListGroup($timetableLessonModel, 'time_id', [
                            'widgetOptions' => [
                                'data' => LessonTime::model()->getListTime(),
                                'htmlOptions' => [
                                    'class' => 'timetable-time form-control select-2',
                                    'empty'  => '--Выбрать--',
                                    'encode' => false
                                ],
                            ],
                        ]
                    ); ?>
                </div>

                <div class="col-sm-3">
                    <?= $form->dropDownListGroup($timetableLessonModel, 'lesson_id', [
                            'widgetOptions' => [
                                'data' =>  Lesson::model()->getListLesson(),
                                'htmlOptions' => [
                                    'class' => 'timetable-lesson form-control select-2',
                                    'empty'  => '--Выбрать--',
                                    'encode' => false
                                ],
                            ],
                        ]
                    ); ?>
                </div>

                <div class="col-sm-3">
                    <?= $form->dropDownListGroup($timetableLessonModel, 'staff_id', [
                            'widgetOptions' => [
                                'data' =>  Staff::model()->getListStaff(),
                                'htmlOptions' => [
                                    'class' => 'timetable-staff form-control select-2',
                                ],
                            ],
                        ]
                    ); ?>
                </div>
                <div class="col-sm-1" style="padding-top: 24px">
                    <button class="button-delete-lesson btn btn-default" type="button">
                        <i class="fa fa-fw fa-trash-o"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php $i = 0; ?>
    <?php if ( !$model->getIsNewRecord() && $model->timetableLesson ):{ ?>

        <div class="row text-center">
            <h3 class="col-sm-2">Время</h3>
            <h3 class="col-sm-4">Занятие</h3>
            <h3 class="col-sm-4">Тренер</h3>
            <h3 class="col-sm-1">Удалить</h3>
        </div>

        <?php foreach ($model->timetableLesson as $i => $lesson):{ ?>

            <div class="product-image row text-center">
                <?= $form->hiddenField($lesson, 'id', [
                    'name' => 'Timetable[lessons]['. $i .'][id]'
                ]); ?>
                <div class="col-sm-2">
                    <?= $form->dropDownListGroup($lesson, 'time_id', [
                            'label' => false,
                            'widgetOptions' => [
                                'data' => LessonTime::model()->getListTime(),
                                'htmlOptions' => [
                                    'class' => 'timetable-time form-control select-2',
                                    'name' => 'Timetable[lessons]['. $i .'][time_id]',
                                    'empty'  => '--Выбрать--',
                                    'encode' => false
                                ],
                            ],
                        ]
                    ); ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->dropDownListGroup($lesson, 'lesson_id', [
                            'label' => false,
                            'widgetOptions' => [
                                'data' =>  Lesson::model()->getListLesson(),
                                'htmlOptions' => [
                                    'class' => 'timetable-lesson form-control select-2',
                                    'name' => 'Timetable[lessons]['. $i .'][lesson_id]',
                                    'empty'  => '--Выбрать--',
                                    'encode' => false
                                ],
                            ],
                        ]
                    ); ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->dropDownListGroup($lesson, 'staff_id', [
                            'label' => false,
                            'widgetOptions' => [
                                'data' =>  Staff::model()->getListStaff(),
                                'htmlOptions' => [
                                    'class' => 'timetable-staff form-control select-2',
                                    'name' => 'Timetable[lessons]['. $i .'][staff_id]',
                                    'empty'  => '--Выбрать--',
                                    'encode' => false
                                ],
                            ],
                        ]
                    ); ?>
                </div>
                <div class="col-sm-1">
                    <a data-id="<?= $lesson->id; ?>" href="<?= Yii::app()->createUrl(
                        '/lesson/timetableBackend/deleteLesson',
                        ['id' => $lesson->id]
                    ); ?>" class="pull-right timetable-delete-lesson btn btn-default"><i class="fa fa-fw fa-trash-o"></i></a>
                </div>
            </div>

        <?php }endforeach; ?>
    <?php }endif; ?>
    <div id="last-iterator" class="hidden" data-last-iterator="<?= $i; ?>"></div>
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
        'htmlOptions' => ['name' => 'submit-type', 'value' => 'index'],
        'label'       => $model->isNewRecord ? 'Создать и закрыть' : 'Сохранить и закрыть',
    ]
); ?>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    $(function () {

        $('.product-image select.select-2').select2('destroy').select2();

        var iLesson = $('#last-iterator').data('last-iterator');
        $('#button-add-lesson').click(function () {
            addLesson();
            return false;
        });

        $(document).keydown(function(event) {
            console.log(event.keyCode);
            if ( (event.keyCode == 107) || (event.keyCode == 187) ) {
                addLesson();
            }
        });

        function addLesson(){
            iLesson++;
            var newImage = $("#timetable-lesson .lesson-template").clone().removeClass('lesson-template').removeClass('hidden').addClass('new-lesson');
            newImage.appendTo("#timetable-lesson");
            newImage.find(".timetable-time").attr('name', 'Timetable[lessons]['+ iLesson +'][time_id]');
            newImage.find(".timetable-lesson").attr('name', 'Timetable[lessons]['+ iLesson +'][lesson_id]');
            newImage.find(".timetable-staff").attr('name', 'Timetable[lessons]['+ iLesson +'][staff_id]');

            $('.new-lesson select.select-2').select2('destroy').select2();
        }

        $(this).closest('.product-image').remove();

        $('#timetable-lesson').on('click', '.button-delete-lesson', function () {
            $(this).closest('.row').remove();
        });

        $('.timetable-delete-lesson').click(function (event) {
            event.preventDefault();
            var deleteUrl = $(this).attr('href');
            var blockForDelete = $(this).closest('.product-image');
            $.ajax({
                type: "POST",
                data: {
                    'id': $(this).data('id'),
                    '<?= Yii::app()->getRequest()->csrfTokenName;?>': '<?= Yii::app()->getRequest()->csrfToken;?>'
                },
                url: '<?= Yii::app()->createUrl('/lesson/timetableBackend/deleteLesson');?>' + '/' + $(this).data('id'),
                success: function () {
                    blockForDelete.remove();
                }
            });
        });

    });
</script>