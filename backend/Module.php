<?php

namespace plathir\smartblog\backend;

use yii\helpers\Url;
use Yii;
use plathir\smartblog\backend\blogAsset;
use \common\helpers\ThemesHelper;

class Module extends \yii\base\Module {

    use \kartik\base\TranslationTrait;

    public $controllerNamespace = 'plathir\smartblog\backend\controllers';
    public $mediaUrl = '';
    public $mediaPath = '';
    public $ImagePath = '';
    public $ImageTempPath = '';
    public $ImagePathPreview = '';
    public $ImageTempPathPreview = '';
    public $CategoryImagePath = '';
    public $CategoryImageTempPath = '';
    public $CategoryImagePathPreview = '';
    public $CategoryImageTempPathPreview = '';
    public $KeyFolder = 'id';
    public $userModel = '';
    public $userNameField = '';
    public $Theme = 'default';
    public $editor = 'CKEditor';
    public $image_width = 400;             // Widget Select Crop Image size
    public $image_height = 300;            // Widget Select Crop Image size 
    public $crop_image_width = 400;        // Widget Crop Area size
    public $crop_image_height = 300;       // Widget Crop Area size
    public $store_image_width = 800;       // image store size
    public $store_image_height = 600;      // image store size
    public $store_thumbnail_width = 266;   // thumbnail store size
    public $store_thumbnail_height = 200;  // thumbnail store size
    public $assetBundle = '';

    public function init() {

        parent::init();
        $this->registerTranslations();
        $this->assetBundle = blogAsset::register(Yii::$app->view);

        // The following three lines initialize i18n for kvtree
//       $dir = '@vendor/kartik-v/yii2-tree-manager/messages';
        // $dir = Yii::getAlias('@backend/messages');
        $cat = 'kvtree';

        $dir = Yii::getAlias('@vendor') . '/plathir/yii2-smart-blog/messages';

//        echo $dir;
//        die();
        $this->initI18N($dir, $cat);

        $helper = new ThemesHelper();
        $path = $helper->ModuleThemePath('blog', 'backend', dirname(__FILE__) . '/themes/smart');
        $path = $path . '/views';

        $this->setViewPath($path);

        $this->controllerMap = [
            'elfinder' => [
                'class' => 'mihaildev\elfinder\Controller',
                'access' => ['@'],
                'disabledCommands' => ['netmount'],
                'roots' => [
                    [
                        'baseUrl' => $this->mediaUrl,
                        'basePath' => $this->mediaPath,
                        'path' => '',
                        'name' => 'Global'
                    ],
                ],
            ],
        ];

        $this->modules = [
            'settings' => [
                'class' => 'plathir\settings\backend\Module',
                'modulename' => 'blog',
//                'inputForm' => 'plathir\smartblog\backend\themes'
            ],
            'treemanager' => [
                'class' => '\kartik\tree\Module',
                'treeViewSettings' => [
                    'nodeActions' => [
                        \kartik\tree\Module::NODE_MANAGE => Url::to(['/blog/categorytree/manage']),
                        \kartik\tree\Module::NODE_SAVE => Url::to(['/blog/categorytree/save']),
                        \kartik\tree\Module::NODE_REMOVE => Url::to(['/blog/categorytree/remove']),
                        \kartik\tree\Module::NODE_MOVE => Url::to(['/blog/categorytree/move']),
                    ],
                    'alertFadeDuration' => 2000,
                    'nodeView' => '@kvtree/views/_form',
                ],
            ]
        ];




//        parent::init();
        // custom initialization code goes here
    }

    public function registerTranslations() {
        /*         * This registers translations for the widgets module * */
        Yii::$app->i18n->translations['blog'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en',
            'basePath' => Yii::getAlias('@vendor/plathir/yii2-smart-blog/messages'),
        ];
    }

}
