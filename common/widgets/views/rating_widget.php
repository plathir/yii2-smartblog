<?php

use yii\widgets\ActiveForm;
use kartik\widgets\StarRating;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Posts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <?php if (!$widget->onlyDisplay) { ?> 

        <?php if ($ratemodel->last_ip != Yii::$app->request->getUserIP()) {
            ?>
            <div class="container">
                <div class="row">
                    <?php Pjax::begin(['id' => 'post-rating', 'enablePushState' => false]); ?>
                    <div class="form-inline">    
                        <?php
                        $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'name' => 'UpdPostrate', 'data-pjax' => true, 'method' => 'post']]);
                        ?>

                        <?=
                        $form->field($ratemodel, 'temprate')->widget(StarRating::classname(), [
                            'pluginOptions' => [
//                                'defaultCaption' => 'test',
                                'min' => 0,
                                'max' => 5,
                                'step' => 1,
                                'showClear' => false,
                                'showCaption' => false,
                                'starCaptions' => $widget->starCaptions,
                                'language' => 'el',
                                'theme' => 'krajee-fa',
                                //       'filledStar' => '<i class="glyphicon glyphicon-heart"></i>',
                                //       'emptyStar' => '<i class="glyphicon glyphicon-heart-empty"></i>',
                                'size' => $widget->size]])->label(false);
                        ?>
                        <?= Html::submitButton('<i class="fa fa-save"></i> ' . Yii::t('blog', 'Rate'), ['class' => 'btn btn-sm btn-primary']) ?>

                        <?php ActiveForm::end(); ?>        
                    </div>   
                    <?php Pjax::end(); ?>        
                </div>

            </div>

        <?php } else {
            ?>
            <div class="inline">
                <?php
                echo StarRating::widget([
                    'name' => 'post_rating',
                    'value' => $ratemodel->temprate,
                    'pluginOptions' => [
                        'displayOnly' => true,
                        'showCaption' => false,
//                    'size' => '10px']
                        'theme' => 'krajee-fa',
                        'size' => $widget->size]
                ]);
                //echo '<span class="label label-info">already rate this post !</span>';
                ?>
            </div>
            <?php
        }
    } else {
        echo StarRating::widget([
            'name' => 'post_rating',
            'value' => $ratemodel->temprate,
            'pluginOptions' => [
                'displayOnly' => true,
                'showCaption' => false,
                'theme' => 'krajee-fa',
                'size' => $widget->size]
        ]);
    }
    ?>

    <script>

    </script>

</div>
