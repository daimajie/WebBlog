<?php

use yii\db\Migration;

/**
 * Class m180923_023502_create_special_tbl
 */
class m180923_023502_create_special_tbl extends Migration
{
    const TBL_NAME = '{{%special}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(static::TBL_NAME, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'name' => $this->string(32)->unique()->comment('专题名称'),
            'image' => $this->string(125)->notNull()->defaultValue('')->comment('专题图片'),
            'description' => $this->string(255)->notNull()->defaultValue('')->comment('专题描述'),
            'count' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('收录文章数目'),
            'comment' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('评论数目'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('创建时间'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('修改时间'),
        ], 'engine=innodb charset=utf8mb4');

        $this->createIndex(
            'idx-special-created_at',
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
        echo "m180923_023502_create_special_tbl cannot be reverted.\n";

        return false;
    }
    */
}
