<?php

use yii\helpers\Html;
use plathir\widgets\common\helpers\LayoutHelper;
?>


<?php
if (\Yii::$app->view->theme) {
    $layoutFile = \Yii::$app->view->theme->pathMap['@app/views'] . DIRECTORY_SEPARATOR . 'layouts/main.php';
} else {
    $layoutFile = '@app/views/layouts/main.php';
}
?>

<?php $this->beginContent($layoutFile); ?>
<?php
?>     

<div class="box box-danger">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Yii::t('blog','Blog') ?></h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <?= Html::a('<i class="fa fa-folder-open"></i>'. Yii::t('blog', 'File Manager'), ['/blog/posts/filemanager'], ['class' => 'btn btn-app']) ?>
        <?= Html::a('<i class="fa fa-gears"></i>'.Yii::t('blog', 'Settings'), ['/blog/settings'], ['class' => 'btn btn-app']) ?>
        <?= Html::a('<i class="fa fa-list"></i>'. Yii::t('blog', 'Categories'), ['/blog/category'], ['class' => 'btn btn-app']) ?>
        <?= Html::a('<i class="fa fa-th-list"></i>'.Yii::t('blog', 'Carousel'), ['/blog/carousel'], ['class' => 'btn btn-app']) ?>
        <?= Html::a('<i class="fa fa-tags"></i>'.Yii::t('blog', 'Tags'), ['/blog/tags'], ['class' => 'btn btn-app']) ?>
    </div>
</div>
<?php
?>

<?php
$layoutHelper = new LayoutHelper();
echo $layoutHelper->LoadLayout(__FILE__, $content);
?>

<?php $this->endContent(); ?>


