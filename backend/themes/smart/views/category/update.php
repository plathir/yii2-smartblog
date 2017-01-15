<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Posts */

$this->title = 'Update Categories: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="categories-update">

    <?=
    $this->render('_updateform', [
        'model' => $model,
    ])
    ?>

</div>