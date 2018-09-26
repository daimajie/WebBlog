<?php

use yii\db\Migration;

/**
 * Class m180921_032141_create_blog_article_tbl
 */
class m180921_032141_create_blog_article_tbl extends Migration
{
    const TBL_NAME = '{{%blog_article}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(static::TBL_NAME, [
            'id' => $this->primaryKey()->unsigned()->comment('主键'),
            'title' => $this->string(125)->notNull()->defaultValue('')->comment('文章标题'),
            'brief' => $this->string(512)->notNull()->defaultValue('')->comment('文章简介'),
            'image' => $this->string(125)->notNull()->defaultValue('')->comment('文章图片'),
            'type' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0)->comment('文章类型'),
            'draft' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0)->comment('草稿箱'),
            'recycle' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0)->comment('回收站'),
            'visited' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('阅读数'),
            'comment' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('评论数'),
            'praise' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('赞赏数'),
            'collect' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('收藏数'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('创建时间'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('修改时间'),

            'category_id' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('所属分类'),
            //'content_id' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('文章内容'),

            'user_id' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('作者'),
        ], 'engine=innodb charset=utf8mb4');

        $this->createIndex(
            'idx-blog_article-draft',
            static::TBL_NAME,
            'draft'
        );

        $this->createIndex(
            'idx-blog_article-recycle',
            static::TBL_NAME,
            'recycle'
        );

        $this->createIndex(
            'idx-blog_article-created_at',
            static::TBL_NAME,
            'created_at'
        );

        $this->addForeignKey(
            'fk-blog_article-category_id',
            static::TBL_NAME,
            'category_id',
            'category',
            'id',
            'CASCADE'
        );


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(static::TBL_NAME);
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180921_032141_create_blog_article_tbl cannot be reverted.\n";

        return false;
    }
    */
}
