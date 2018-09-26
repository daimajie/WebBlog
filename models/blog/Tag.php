<?php

namespace app\models\blog;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%tag}}".
 *
 * @property string $id 主键
 * @property string $name 标签名称
 * @property string $created_at 创建时间
 * @property string $updated_at 修改时间
 * @property string $category_id 所属分类
 *
 * @property Category $category
 * @property TagArticle[] $tagArticles
 */
class Tag extends \yii\db\ActiveRecord
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
        return '{{%tag}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'category_id'], 'required'],
            [['category_id'], 'integer'],
            [['name'], 'string', 'max' => 8],
            [['category_id'], 'exist', 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['name'], 'upperLimit'],
            [['name'], 'uniqueOnCategory']
        ];
    }

    /**
     * 检测当前分类下标签是否已存在
     * @param $attr
     * @return bool
     */
    public function uniqueOnCategory($attr){
        if($this->hasErrors()){
            return false;
        }

        $exist = static::find()->where(['name'=>$this->name])->count();
        if($exist){
            $this->addError($attr, '该标签已经存在。');
            return false;
        }

        return true;
    }


    /**
     * 检测当前分类下标签是否已达上限
     * @param $attr
     * @return bool
     */
    public function upperLimit($attr){
        if($this->hasErrors()){
            return false;
        }

        $count = static::find()->where(['category_id'=>$this->category_id])->count();
        $limit = Yii::$app->params['upperLimit']['tag'];

        if($count >= $limit){
            $this->addError($attr, '该分类下标签已达上限，创建失败。');
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
            'id' => 'ID',
            'name' => '标签名称',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
            'category_id' => '所属分类',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTagArticles()
    {
        return $this->hasMany(TagArticle::class, ['tag_id' => 'id']);
    }

    /**
     * 根据分类获取标签
     * @param $category_id int #分类
     */
    public static function getTagsByCategory($category_id){
        return static::find()
            ->where(['category_id' => $category_id])
            ->select(['name'])
            ->indexBy('id')
            ->asArray()
            ->column();
    }

    public function discard(){
        //先删除标签关联
        TagArticle::deleteAll(['tag_id' => $this->id]);

        //删除标签数据
        $this->delete();
    }



}
