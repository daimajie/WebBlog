<?php

use yii\db\Migration;

/**
 * Class m181005_045218_create_comment_tbl
 */
class m181005_045218_create_comment_tbl extends Migration
{
    const TBL_NAME = '{{%comment}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TBL_NAME, [
            'id' => $this->primaryKey()->unsigned()->comment('主键'),
            'comment' => $this->string(512)->notNull()->defaultValue('')->comment('评论内容'),
            'content_id' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('文章内容'),
            'comment_id' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('评论ID'),
            'user_id' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('评论用户'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('评论时间'),
        ], 'engine=innodb charset=utf8mb4');

        $this->createIndex(
            'idx-comment-content_id',
            self::TBL_NAME,
            'content_id'
        );
        $this->createIndex(
            'idx-comment-comment_id',
            self::TBL_NAME,
            'comment_id'
        );
        $this->createIndex(
            'idx-comment-user_id',
            self::TBL_NAME,
            'user_id'
        );
        $this->createIndex(
            'idx-comment-created_at',
            self::TBL_NAME,
            'created_at'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TBL_NAME);
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181005_045218_create_comment_tbl cannot be reverted.\n";

        return false;
    }
    */
}
