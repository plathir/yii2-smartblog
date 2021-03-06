<?php
namespace plathir\smartblog\backend\models;

use Yii;
use plathir\cropper\behaviors\UploadImageBehavior;
use yii\behaviors\SluggableBehavior;

/*
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $image
 */

class Category extends \yii\db\ActiveRecord {

    use \plathir\smartblog\backend\traits\ModuleTrait;

    public static function tableName() {
        return '{{%categories}}';
    }

    public function behaviors() {
        return [
            'uploadImageBehavior' => [
                'class' => UploadImageBehavior::className(),
                'attributes' => [
                    'image' => [
                        'path' => $this->module->CategoryImagePath,
                        'temp_path' => $this->module->CategoryImageTempPath,
                        'url' => $this->module->CategoryImagePathPreview,
                        'key_folder' => 'id',
                    ],
                ]
            ],
        ];
    }

    public function rules() {
        //  $rules = parent::rules();

        return [
            [['id'], 'required'],
            [['name'], 'required'],
            [['slug'], 'string'],
            [['description'], 'string'],
            [['image'], 'string']
        ];
    }

    public function attributeLabels() {
        
        return [
            'id' => Yii::t('blog', 'ID'),
            'name' => Yii::t('blog', 'Name'),
            'description' => Yii::t('blog', 'Description'),
            'image' => Yii::t('blog', 'Image'),
            'active' => Yii::t('blog', 'Active'),
        ];
    }

    function getImageUrl() {
        if ($this->image) {
            return Yii::getAlias($this->module->CategoryImagePathPreview) . '/' . $this->id . '/' . $this->image;
        } else {
            return $this->module->assetBundle->baseUrl . '/img/nophoto.png';
            //return Yii::getAlias($this->module->CategoryImagePathPreview) . '/nophoto.png';
        }
    }

        function getImageUrlThumb() {
        if ($this->post_image) {
            return Yii::getAlias($this->module->CategoryImagePathPreview) . '/' . $this->id . '/thumbs/' . $this->image;
        } else {
            return $this->module->assetBundle->baseUrl . '/img/nophoto_thumb.png';
        }
    }
    
    
}
