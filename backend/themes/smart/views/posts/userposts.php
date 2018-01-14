<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\datecontrol\DateControl;
use kartik\tree\TreeViewInput;
use plathir\smartblog\backend\models\Categorytree as Category;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Posts_s */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Posts Lists for user : <?= $username ?> </h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>

    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="table-responsive">

            <?php // echo $this->render('_search', ['model' => $searchModel]);   ?>

            <p>
                <?= Html::a('Create Posts', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'header' => 'Image',
                        'format' => 'raw',
                        'value' => function($model, $key, $index, $grid) {
                            return Html::img($model->imageurl, ['alt' => '...',
                                        'width' => '50',
                                        'align' => 'center']);
                        },
                        'filterOptions' => ['class' => 'hidden-xs hidden-sm hidden-md'],
                        'headerOptions' => ['class' => 'hidden-xs hidden-sm'],
                        'contentOptions' => ['data-columnname' => 'Image', 'class' => 'hidden-xs hidden-sm hidden-md'],
                    ],                     
                    'id',
                    [
                        'label' => 'Descriprion',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return Html::a($data->description, ['/blog/posts/view', 'id' => $data->id]);
                        },
                            ],
                            //'description',
                            [
                                'attribute' => 'user_created',
                                'value' => function($model, $key, $index, $widget) {
                                    $userModel = new $model->module->userModel();
                                    return $userModel::findOne(['id' => $model->user_created])->{$model->module->userNameField};
                                },
                                        'format' => 'html',
                                        'contentOptions' => ['style' => 'width: 10%;']
                                    ],
                                    [
                                        'attribute' => 'created_at',
                                        'format' => ['date', 'php:d-m-Y'],
                                    ],
                                    [
                                        'attribute' => 'user_last_change',
                                        'value' => function($model, $key, $index, $widget) {
                                            $userModel = new $model->module->userModel();
                                            return $userModel::findOne(['id' => $model->user_last_change])->{$model->module->userNameField};
                                        },
                                                'format' => 'html'],
                                            [
                                                'attribute' => 'updated_at',
                                                'format' => ['date', 'php:d-m-Y'],
                                            ],
                                            [
                                                'attribute' => 'publish',
                                                'value' => function($model, $key, $index, $widget) {
                                                    return $model->publish == true ? '<span class="label label-success">Published</span>' : '<span class="label label-danger">Unpublished</span>';
                                                },
                                                'format' => 'html',
                                                'contentOptions' => ['style' => 'width: 10%;']
                                            ],
                                            [
                                                'attribute' => 'category',
                                                'contentOptions' => ['style' => 'width: 10%;']
                                            ],
                                        ],
                                    ]);
                                    ?>

        </div>
    </div>
</div>
