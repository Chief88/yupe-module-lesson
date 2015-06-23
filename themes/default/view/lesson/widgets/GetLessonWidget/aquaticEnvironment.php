<h4 class="lined-header">
    <span class="lined-header__content"><?= $models[0]->type->name; ?></span>
</h4>
<div class="sepa-20"></div>
<ul class="programs">

    <?php foreach($models as $model):{ ?>
        <li class="programs__item">
            <div class="programs__img row">

                <?php if( !empty($model->image) ):{ ?>
                    <img src="<?= $model->getImageUrl(320); ?>"
                         alt="<?= $model->name; ?>"
                         class="col-lg-12 col-md-12 col-sm-12 col-xs-12" />
                <?php }endif; ?>

            </div>
            <div class="programs__title"><?= $model->name; ?></div>
            <div class="programs__content">
                <?= $model->description; ?>
            </div>
    <?php }endforeach; ?>

</ul>

<?php if(!empty($typeSlug)):{ ?>
    <div class="load-content">
        <a href="/timetable?type=<?= $typeSlug; ?>" class="btn btn-primary">Смотреть расписание</a>
    </div>
<?php }endif; ?>