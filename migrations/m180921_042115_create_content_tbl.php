<?php

use yii\db\Migration;

/**
 * Class m180921_042115_create_content_tbl
 */
class m180921_042115_create_content_tbl extends Migration
{
    const TBL_NAME = '{{%content}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(static::TBL_NAME, [
            'id' => $this->primaryKey()->unsigned()->comment('主键'),
            'type' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(1)->comment('内容类型: 1为博客文章、2为话题文章'),
            'article_id' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('文章ID'),
            'words' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('文章字数'),
            'content' => $this->text()
        ], 'engine=innodb charset=utf8mb4');

        $this->createIndex(
            'idx-content-article_id',
            static::TBL_NAME,
            'article_id'
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
        echo "m180921_042115_create_content_tbl cannot be reverted.\n";

        return false;
    }
    */
}
