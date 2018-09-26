<?php

use yii\db\Migration;

/**
 * Class m180923_023614_create_special_article_tbl
 */
class m180923_023614_create_special_article_tbl extends Migration
{
    const TBL_NAME = '{{%special_article}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable(static::TBL_NAME, [
            'id' => $this->primaryKey()->unsigned()->comment('主键'),
            'title' => $this->string(125)->notNull()->defaultValue('')->comment('文章标题'),
            'draft' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0)->comment('草稿箱'),
            'recycle' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0)->comment('回收站'),
            'visited' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('阅读数'),
            'comment' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('评论数'),

            'special_id' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('所属专题'),
            'chapter_id' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('所属章节'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('创建时间'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('修改时间'),
            'user_id' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('作者'),

        ], 'engine=innodb charset=utf8mb4');

        //special_id
        $this->addForeignKey(
            'fk-special_article-special_id',
            static::TBL_NAME,
            'special_id',
            '{{%special}}',
            'id',
            'CASCADE'
        );

        //chapter_id
        $this->addForeignKey(
            'fk-special_article-chapter_id',
            static::TBL_NAME,
            'chapter_id',
            '{{%chapter}}',
            'id',
            'CASCADE'
        );

        //created_at
        $this->createIndex(
            'idx-special_article-created_at',
            static::TBL_NAME,
            'created_at'
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
        echo "m180923_023614_create_special_article_tbl cannot be reverted.\n";

        return false;
    }
    */
}
