<?php

use yii\helpers\Html;
use plathir\widgets\common\helpers\PositionHelper;
$positionHelper = new PositionHelper();

?>

<div class="smartblog-default-index">
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">Posts</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body">
            <?= Html::a(Yii::t('app', '<i class="fa fa-folder-open"></i>File Manager'), ['/blog/posts/filemanager'], ['class' => 'btn btn-app']) ?>
            <?= Html::a(Yii::t('app', '<i class="fa fa-gears"></i>Settings'), ['/blog/settings'], ['class' => 'btn btn-app']) ?>
            <?= Html::a(Yii::t('app', '<i class="fa fa-list"></i>Categories'), ['/blog/category'], ['class' => 'btn btn-app']) ?>
            <?= Html::a(Yii::t('app', '<i class="fa fa-th-list"></i>Posts Preview'), ['/blog/posts/list'], ['class' => 'btn btn-app']) ?>
            <?= Html::a(Yii::t('app', '<i class="fa fa-tags"></i>Tags'), ['/blog/tags'], ['class' => 'btn btn-app']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">        
            <?= $positionHelper->LoadPosition('be_blog_position1'); ?>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-4">
            <?= $positionHelper->LoadPosition('be_blog_position2'); ?>
        </div>
        <div class="col-lg-8">
             <?= $positionHelper->LoadPosition('be_blog_position3'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <?= $positionHelper->LoadPosition('be_blog_position3'); ?>
        </div>  
    </div>
    
</div>

