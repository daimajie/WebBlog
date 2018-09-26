<?php

use yii\db\Migration;

/**
 * Class m180923_023537_create_chapter_tbl
 */
class m180923_023537_create_chapter_tbl extends Migration
{
    const TBL_NAME = '{{%chapter}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(static::TBL_NAME, [
            'id' => $this->primaryKey()->unsigned()->comment('主键'),
            'title' => $this->string(32)->notNull()->defaultValue(0)->comment('章节标题'),
            'special_id' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('所属专题'),
            'count' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('文章计数'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('创建时间'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('修改时间'),
        ], 'engine=innodb charset=utf8mb4');
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
        echo "m180923_023537_create_chapter_tbl cannot be reverted.\n";

        return false;
    }
    */
}
