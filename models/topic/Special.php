<?php

namespace app\models\topic;

use app\components\helper\Helper;
use app\components\services\UploadService;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%special}}".
 *
 * @property string $id ID
 * @property string $name 专题名称
 * @property string $image 专题图片
 * @property string $description 专题描述
 * @property string $count 收录文章数目
 * @property string $created_at 创建时间
 * @property string $updated_at 修改时间
 *
 * @property SpecialArticle[] $specialArticles
 */
class Special extends \yii\db\ActiveRecord
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
        return '{{%special}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description','image'], 'required'],
            [['name'], 'string', 'max' => 32],
            [['image'], 'string', 'max' => 125],
            [['description'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '专题名称',
            'image' => '专题图片',
            'description' => '专题描述',
            'count' => '收录文章数目',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpecialArticles()
    {
        return $this->hasMany(SpecialArticle::class, ['special_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChapters()
    {
        return $this->hasMany(Chapter::class, ['special_id' => 'id']);
    }

    /**
     * 修改专题
     */
    public function renew(){
        if( !$this->validate() )
            return false;

        //判断是否修改了专题图片
        if($this->getOldAttribute('image') && $this->image !== $this->getOldAttribute('image')){
            //删除旧图片
            UploadService::deleteImage($this->getOldAttribute('image'));
        }

        return $this->save(false);

    }


    /**
     * 获取最新专题
     */
    public static function getNewSpecials($page, $limit, $search){
        $query = static::find();

        //按条件搜索
        if(!empty($search))
            $query->andFilterWhere(['like', 'name', $search]);

        //总数
        $count = $query->count();


        $specials = $query->select(['id','text'=>'name'])->offset($page-1)->limit($limit)->asArray()->all();
        return [
            'count' => $count,
            'specials'=> $specials
        ];
    }

    /**
     * 获取专题列表用户下拉搜索框
     * @param $page int 请求页
     * @param $limit int 限数
     * @param bool $more 是否加载更多
     * @return array
     */
    public static function SpecialFormat($page, $limit, $search='', $more = true){

        $data = static::getNewSpecials($page, $limit, $search);

        return [
            'results' => $data['specials'],
            "pagination" => [
                "more" => $more
            ],
            'count_filtered' => $data['count']

        ];
    }

    /**
     * 根据章节id获取所属专题
     * @param $spcial_id int 专题id
     * @return array
     */
    public static function getBelongTo($spcial_id){
        return static::find()->select(['name'])->indexBy('id')->where(['id'=>$spcial_id])->asArray()->column();
    }
    
    
    /**
     * 获取专题列表 （专题列表）
     */
    public static function getSpecials($words = ''){
        $query = static::find();

        if( $words ) $query->andWhere(['like', 'name', $words]);

        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count]);

        $specials = $query->orderBy(['created_at'=>SORT_DESC])->offset($pagination->offset)->limit($pagination->limit)->asArray()->all();

        return [
            'specials' => $specials,
            'pagination' => $pagination
        ];
    }

    /**
     * 获取指定专题 (专题详情 目录列表)
     * @param int $special_id 专题id
     * @return array
     */
    public static function getSpecial($special_id){
        return static::find()
            ->where(['id'=>$special_id])
            ->with(['chapters'])
            ->with(['chapters.specialArticlesTitle'])
            ->orderBy(['id' => SORT_ASC])
            ->asArray()
            ->one();


    }


}
