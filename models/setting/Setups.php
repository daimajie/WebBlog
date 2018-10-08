<?php

namespace app\models\setting;

use app\components\services\UploadService;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%setups}}".
 *
 * @property string $id 主键
 * @property string $name 站点名称
 * @property string $keywords 关键字
 * @property string $description 站点描述
 * @property string $image 图片
 * @property string $email 联系邮箱
 * @property string $about 关于我
 * @property string $created_at 创建时间
 * @property string $updated_at 修改时间
 */
class Setups extends \yii\db\ActiveRecord
{
    public $file;

    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%setups}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'keywords', 'description', 'sign', 'email', 'about', 'history'], 'required'],
            [['name'], 'string', 'max' => 12],
            [['keywords'], 'string', 'max' => 255],
            [['description', 'about'], 'string', 'max' => 512],
            [['sign','image'], 'string', 'max' => 125],
            [['email'], 'string', 'max' => 64],
            [['history'], 'string'],
            [['file'], 'image', 'extensions' => 'png, jpg, jpeg, gif',
                'minWidth' => 100, 'maxWidth' => 1000,
                'minHeight' => 100, 'maxHeight' => 1000,
                ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'name' => '站点名称',
            'sign' => '签名',
            'keywords' => 'SEO关键字',
            'description' => 'SEO站点描述',
            'image' => '图片',
            'email' => '联系邮箱',
            'about' => '关于我',
            'history' => '我的故事',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }

    public function store(){
        $this->file = UploadedFile::getInstanceByName('file');


        if( !$this->validate() ) return false;

        //保存图片
        if( $this->file ){
            //生成图片地址
            $ret = UploadService::generateImage('image', $this->file->extension);
            if( $this->file->saveAs($ret['fullPath']) ){
                $this->image = $ret['savePath'];
            }else{
                $this->addError('file', '图片保存失败，请重试。');
                return false;
            }

        }

        return $this->save(false);

    }
}
