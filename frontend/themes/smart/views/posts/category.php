<?php

use yii\widgets\ListView;
use yii\helpers\Html;

$this->title = $categ->name;
$this->params['breadcrumbs'][] = ['label' => 'Index', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="body-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <?= Html::img($categ->imageUrl, ['class' => 'img-responsive', 'width' => '300px']); ?>
                    </div>
                    <div class="col-lg-6">
                        <?= $categ->description ?>
                    </div>
                </div>
            </div>
            <hr>
            <?php
            $view = '/post_templates/_view_media_list';
            $layout = '{summary}{items}{pager}';
            echo ListView::widget([
                'dataProvider' => $dataProvider,
                //'itemOptions' => ['class' => 'media'],
                'itemView' => $view,
                'layout' => $layout,
                'summary' => '',
            ]);
            ?>
        </div>
    </div>
</div>