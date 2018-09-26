<?php

namespace app\models\setting;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%friend}}".
 *
 * @property string $id 主键
 * @property string $site 站点名称
 * @property string $url 站点地址
 * @property int $sort 排序凭证
 * @property string $created_at 创建时间
 * @property string $updated_at 修改时间
 */
class Friend extends \yii\db\ActiveRecord
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
        return '{{%friend}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['site', 'url'], 'required'],
            [['site'], 'string', 'max' => 32],
            [['url'], 'string', 'max' => 125],
            [['sort'], 'integer', 'max' => 127],
            [['site'], 'unique'],
            ['url', 'url', 'defaultScheme' => 'http'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'site' => '站点名称',
            'url' => '站点地址',
            'sort' => '排序凭证',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }
}
