<?php

use yii\helpers\Html;
use yii\web\View;
use yii\data\ArrayDataProvider;
use yii\widgets\ListView;
?>
<div class="body-content">
    <div class="row-fluid">
        <?php
        $view = '/post_templates/_view_' . $widget->typeView . '_list';

        $provider = new ArrayDataProvider([
            'allModels' => $posts,
//            'pagination' => [
//                'pageSize' => 3,
//            ],
        ]);
        if ($widget->typeView == 'media') {
            $layout = '<div class="blog-sidebar-right">
                <div class="container">
                    <div class="row">
                        <div class="panel panel-default">
                            <div class="panel-heading">' . Yii::t('blog', 'Latest Posts') . '</div>
                            <div class="panel-body">
                                {summary}{items}{pager}
                           </div>
                        </div>
                    </div>
                </div>
            </div>';
        } else {
            $layout = '{summary}{items}{pager}';
        }

        echo
        ListView::widget([
            'dataProvider' => $provider,
          //  'itemOptions' => ['class' => 'media'],
            'itemView' => $view,
            'layout' => $layout,
            'summary' => '',
        ]);
        ?>
    </div>
</div>
