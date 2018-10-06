<?php
namespace app\components\widgets\comment\models;
use app\components\helper\Helper;
use app\models\blog\BlogArticle;
use app\models\comment\Comment as CommentModel;
use app\models\blog\Content;
use yii\base\Exception;
use yii\data\Pagination;
use yii\helpers\Html;
use Yii;

class Comment extends CommentModel
{
    public function rules()
    {
        return [
            [['content_id', 'comment_id', 'comment'], 'required'],
            [['content_id', 'comment_id'], 'integer'],
            [['content_id'], 'exist', 'targetClass' =>Content::class, 'targetAttribute' => 'id' ],
            [['comment_id'], 'exist', 'targetAttribute' => 'id', 'when' => function(){
                    return $this->comment_id != 0;
            }],
        ];
    }

    public function attributeLabels()
    {
        return [
            'comment' => '评论',
            'comment_id' => '所属评论',
            'content_id' => '评论文章'
        ];
    }

    /**
     * 获取评论列表
     * @param $content_id int 文章内容id
     * @param $page int 页码
     * @param $limit int 限数
     * @return array
     */
    public static function getComments($content_id, $page, $limit){
        $query = self::find()
            ->where(['content_id' => $content_id])
            ->andWhere(['comment_id'  => 0]);

        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count]);
        $pagination->pageParam = 'page';
        $pagination->pageSizeParam = 'limit';

        $pagination->setPage($page-1);
        $pagination->setPageSize($limit);

        $comments =  $query->select(['id', 'content_id', 'comment_id', 'user_id', 'comment','created_at'])
            ->with('user', 'replys', 'replys.user')
            ->orderBy(['created_at'=>SORT_DESC])
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->asArray()
            ->all();

        //排序
        static::proccessData($comments);

        return [
            'comments' => $comments,
            'pagination' => $pagination
        ];

    }

    /**
     * 递归排序评论内容
     */
    public static function proccessData(&$comments){

        foreach( $comments as &$comment ){
            $comment['comment'] = Html::encode($comment['comment']);
            $comment['created_at'] = Helper::formatDate($comment['created_at']);
            $comment['user']['image'] = Helper::showImage($comment['user']['image']);
            $comment['user']['username'] = Html::encode($comment['user']['username']);
            $comment['owner'] = (!Yii::$app->user->isGuest) && ($comment['user']['id'] === Yii::$app->user->id);
            if(!empty($comment['replys'])){
                static::proccessData($comment['replys']);
            }
        }
    }

    public function deleteComment(){

        $transaction = static::getDb()->beginTransaction();
        try{
            $ret = static::deleteAll(['comment_id' => $this->id]);

            if ( ($ret === false) || !$this->delete() ){
                throw new Exception('删除评论失败，请重试。');
            }

            $transaction->commit();
            return true;
        }catch (\Exception $e){

            $transaction->rollBack();
            return false;
        }catch (\Throwable $e){

            $transaction->rollBack();
            return false;
        }


    }




}