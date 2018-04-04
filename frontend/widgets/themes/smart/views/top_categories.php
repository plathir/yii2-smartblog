<?php

use yii\helpers\Html;
use plathir\user\common\helpers\UserHelper;
?>


<div class="panel panel-default">
    <div class="panel-heading"><?= Yii::t('blog', 'Top Categories') ?></div>
    <div class="panel-body"> 
        <div class="table-responsive">
            <table class="table no-margin">
                <thead>

                </thead>
                <tbody>
                    <?php
                    foreach ($topCategories as $Category) {
                        ?>
                        <tr>
                            <td> 
                        <?= Html::img($Category["image"], ['alt' => '...',
                                       // 'class' => 'img-circle',
                                        'width' => '40',
                                        'align' => 'center']); ?>
                            </td>                            
                            <td><?= Html::a($Category["name"], ['/blog/posts/category', 'id' => $Category["category"]]) ?></td>
                            <td><?= $Category['cnt'] ?></td>
                            
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div><!-- /.table-responsive -->
    </div>
</div>
