<?php if (!empty($categoryModel)) {
    $this->pageTitle = !empty($categoryModel->page_title) ? $categoryModel->page_title : $this->pageTitle;
    $this->metaDescription = !empty($categoryModel->seo_description) ? $categoryModel->seo_description : $this->metaDescription;
    $this->metaKeywords = !empty($categoryModel->seo_keywords) ? $categoryModel->seo_keywords : $this->metaKeywords;
    $this->metaNoIndex = $categoryModel->no_index == 1 ? true : false;
}
$mainAssets = Yii::app()->getTheme()->getAssetsUrl();
?>

<div class="container">
    <nav>
        <ul itemtype="https://data-vocabulary.org/Breadcrumb" itemscope="" class="breadcrumb">
            <li><a itemprop="url" href="/"><span itemprop="title">Главная</span></a>
            <li><span itemprop="title">Расписание</span>
        </ul>
    </nav>
    <h1>Расписание</h1>

    <?php if($isFilter):{ ?>
        <a class="btn btn-default-small" href="/timetable">Сбросить фильтр</a>
        <div class="sepa-10"></div>
    <?php }endif; ?>

    <?php if(count($models) == 0):{ ?>
        <div>Нет результатов</div>
    <? }endif; ?>

    <ul class="timetable-tabs nav nav-tabs jstabs" role="tablist">
        <?php $i = 0; ?>
        <?php foreach($categories as $slug => $category):{ ?>

            <li role="presentation" class="<?= $i == 0 ? 'active' : ''; ?>">
                <a href="#<?= $slug; ?>" class="dashed"><span><?= $category->name; ?></span></a>

            <?php $i++;?>
        <?php }endforeach; ?>
    </ul>

    <div class="tab-content">

        <?php $i = 0; ?>
        <?php foreach($categories as $slug => $category):{ ?>

        <div role="tabpanel" class="tab-pane fade <?= $i == 0 ? 'in active' : ''; ?>" id="<?= $slug; ?>">
            <table class="timetable tabs-table" data-visible-col="1">
                <thead>
                <tr class="timetable-dates tabs-table__tabs">
                    <th class="hidden-xs">
                        Время
                    </th>

                    <?php foreach($listDaysWeek as $i => $dayWeek):{ ?>
                        <th class="tabs-table__tab tabs-table__col-header_<?= $i; ?>" data-show-col="<?= $i; ?>">
                            <div class="tabs-table__full-view">
                                <div class="timetable-dates__day-of-week"><?= $dayWeek['full']['dayWeek']; ?></div>
                                <div class="timetable-dates__date"><?= $dayWeek['full']['dayAndMonth']; ?></div>
                            </div>
                            <div class="tabs-table__short-view">
                                <div class="timetable-dates__day-of-week"><?= $dayWeek['short']['dayWeek']; ?></div>
                                <div class="timetable-dates__date"><?= $dayWeek['short']['dayAndMonth']; ?></div>
                            </div>
                        </th>
                    <?php }endforeach; ?>

                </tr>
                </thead>

                <tbody>

                <?php $listTimeNoEmpty = [];
                foreach($listTime as $timeId => $timeBegin) {
                    foreach ($models as $key => $model) {
                        if (($model->lesson->category_id == $category->id) && ($model->time_id == $timeId)) {
                            $listTimeNoEmpty[$timeId] = $timeBegin;
                        }
                    }
                } ?>

                <?php foreach($listTimeNoEmpty as $timeId => $timeBegin):{ ?>

                    <tr>
                        <td><?= $timeBegin; ?></td>

                        <?php foreach($listDaysWeek as $i => $dayWeek):{ ?>
                            <?php $flag = true; ?>

                                <td class="tabs-table__tab-content tabs-table__col_<?= $i; ?>">

                                    <?php foreach($models as $key => $model):{ ?>

                                        <?php if( ($model->lesson->category_id == $category->id) &&
                                            ($model->time_id == $timeId) &&
                                            ($model->date->date == $dayWeek['date']) ):{ ?>

                                            <div class="open-timetable-popup"
                                                 data-popup-text="<?= $model->lesson->description?>">
                                                <strong><?= $model->lesson->name; ?></strong>
                                                <ins><?= !empty($model->lesson->hall) ? '<br>' . $model->lesson->hall : ''?></ins>
                                                <br><?= $model->teacher->getFio()?>
                                            </div>

                                            <?php $flag = false; unset($models[$key]); ?>
                                        <?php }endif; ?>
                                    <?php }endforeach; ?>

                                    <?php if($flag):{ ?>
                                        &nbsp;
                                    <?php }endif; ?>

                                </td>


                        <?php }endforeach ?>

                    </tr>

                <?php }endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php $i++;?>
    <?php }endforeach; ?>

    </div>

</div>