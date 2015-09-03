<?php $type = $models[0]->type; ?>
<h4 class="lined-header"><span class="lined-header__content"><?= $type->name; ?></span></h4>
<div class="sepa-20"></div>
<div class="row">
    <img src="<?= $type->getImageUrl(980, 0); ?>"
         alt="<?= $type->name; ?>"
         class="col-lg-12 col-md-12 col-sm-12 col-xs-12" />
</div>
<div class="sepa-30"></div>

<?php if(!empty($type->description)):{ ?>

    <div class="row">
        <div class="ol-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?= $type->description; ?>
        </div>
    </div>
    <div class="sepa-30"></div>

<?php }endif; ?>

<ul class="programs row">

    <?php foreach($models as $model):{ ?>
    <li class="programs__item col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="programs__title"><?= $model->name; ?></div>
        <div class="programs__content"><?= $model->description; ?></div>
    <?php }endforeach; ?>

</ul>

<?php if(!empty($typeSlug)):{ ?>
    <div class="load-content">
        <a href="/timetable?type=<?= $typeSlug; ?>" class="btn btn-primary">Смотреть расписание</a>
    </div>
<?php }endif; ?>