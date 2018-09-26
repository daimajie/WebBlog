<?php

use yii\db\Migration;

/**
 * Class m180921_035953_create_tag_article_tbl
 */
class m180921_035953_create_tag_article_tbl extends Migration
{
    const TBL_NAME = '{{%tag_article}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(static::TBL_NAME, [
            'tag_id' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('标签ID'),
            'blog_article_id' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('文章ID'),
        ], 'engine=innodb charset=utf8mb4');



        $this->addForeignKey(
            'fk-tag_article-tag_id',
            static::TBL_NAME,
            'tag_id',
            '{{%tag}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-tag_article-article_id',
            static::TBL_NAME,
            'blog_article_id',
            '{{%blog_article}}',
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
        echo "m180921_035953_create_tag_article_tbl cannot be reverted.\n";

        return false;
    }
    */
}
