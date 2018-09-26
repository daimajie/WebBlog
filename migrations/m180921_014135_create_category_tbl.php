<?php

use yii\db\Migration;

/**
 * Class m180921_014135_create_category_tbl
 */
class m180921_014135_create_category_tbl extends Migration
{
    const TBL_NAME = '{{%category}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(static::TBL_NAME, [
            'id' => $this->primaryKey()->unsigned()->comment('主键'),
            'name' => $this->string(12)->notNull()->defaultValue('')->comment('分类名称'),
            'desc' => $this->string(255)->notNull()->defaultValue('')->comment('分类描述'),
            'count' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('收录数目'),
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
        echo "m180921_014135_create_category_tbl cannot be reverted.\n";

        return false;
    }
    */
}
