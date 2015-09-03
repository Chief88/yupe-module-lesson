<?php $type = $models[0]->type; ?>

<?php if(!empty($type->description)):{ ?>

    <div class="row">
        <div class="ol-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?= $type->description; ?>
        </div>
    </div>
    <div class="sepa-30"></div>

<?php }endif; ?>

<ul class="programs">

    <?php foreach($models as $model):{ ?>

            <li class="programs__item">
                <div class="programs__title"><?= $model->name; ?></div>
                <div class="programs__content">
                    <?= $model->description; ?>
                </div>
                <div class="programs__img row">

                    <?php if( !empty($model->image) ):{ ?>
                        <img src="<?= $model->getImageUrl(320); ?>"
                             alt="<?= $model->name; ?>"
                             class="col-lg-12 col-md-12 col-sm-12 col-xs-12" />
                    <?php }endif; ?>

                </div>

    <?php }endforeach; ?>

</ul>

<?php if(!empty($typeSlug)):{ ?>
    <div class="load-content">
        <a href="/timetable?type=<?= $typeSlug; ?>" class="btn btn-primary">Смотреть расписание</a>
    </div>
<?php }endif; ?>