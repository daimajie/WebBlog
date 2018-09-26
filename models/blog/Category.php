<?php

namespace app\models\blog;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property string $id 主键
 * @property string $name 分类名称
 * @property string $desc 分类描述
 * @property string $count 收录数目
 * @property string $created_at 创建时间
 * @property string $updated_at 修改时间
 */
class Category extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'unique'],
            [['name'], 'string', 'max' => 12],
            [['desc'], 'string', 'max' => 255],
            [['name'], 'upperLimit'],
        ];
    }

    public function upperLimit($attr){
        if( $this->hasErrors() ){
            return false;
        }
        $count = static::find()->count();
        $limit = Yii::$app->params['upperLimit']['category'];

        if($count >= $limit){
            $this->addError($attr, '分类数目已达上限，创建失败。');
            return false;
        }
        return true;

    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'name' => '分类名称',
            'desc' => '分类描述',
            'count' => '收录数目',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }

    //获取所有分类用户下拉框
    public static function getAllCategorys(){
        return static::find()
            ->select(['name'])
            ->indexBy('id')
            ->asArray()
            ->column();
    }

    //删除分类
    public function discard(){
        //检测是否有标签
        $tagCount = Tag::find()->where(['category_id'=>$this->id])->count();

        //检测是否有文章
        $articleCount = Article::find()->where(['category_id'=>$this->id])->count();

        //没有标签和文章就删除分类
        if($articleCount || $tagCount){
            return false;
        }else{
            return $this->delete();
        }
    }
}
