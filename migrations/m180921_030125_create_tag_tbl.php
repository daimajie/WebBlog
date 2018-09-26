<?php

use yii\db\Migration;


/**
 * Class m180921_030125_create_tag_tbl
 */
class m180921_030125_create_tag_tbl extends Migration
{
    const TBL_NAME = '{{%tag}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(static::TBL_NAME, [
            'id' => $this->primaryKey()->unsigned()->comment('主键'),
            'name' => $this->string(8)->notNull()->defaultValue('')->comment('标签名称'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('创建时间'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('修改时间'),
            'category_id' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('所属分类')
        ], 'engine=innodb charset=utf8mb4');

        //外键索引
        $this->addForeignKey(
            'fk-tag-category_id',
            static::TBL_NAME,
            'category_id',
            '{{%category}}',
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
        echo "m180921_030125_create_tag_tbl cannot be reverted.\n";

        return false;
    }
    */
}
