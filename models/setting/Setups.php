<?php

namespace app\models\setting;

use Yii;
use yii\behaviors\TimestampBehavior;

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
            [['name', 'keywords', 'description'/*, 'image'*/, 'email', 'about'], 'required'],
            [['name'], 'string', 'max' => 12],
            [['keywords'], 'string', 'max' => 255],
            [['description', 'about'], 'string', 'max' => 512],
            [['image'], 'string', 'max' => 128],
            [['email'], 'string', 'max' => 64],
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
            'keywords' => '关键字',
            'description' => '站点描述',
            'image' => '图片',
            'email' => '联系邮箱',
            'about' => '关于我',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }
}
