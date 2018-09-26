<?php

use yii\db\Migration;

/**
 * Class m180924_091728_create_friend_tbl
 */
class m180924_091728_create_friend_tbl extends Migration
{
    const TBL_NAME = '{{%friend}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(static::TBL_NAME, [
            'id' => $this->primaryKey()->unsigned()->comment('主键'),
            'site' => $this->string(32)->unique()->comment('站点名称'),
            'url' => $this->string(125)->notNull()->defaultValue('')->comment('站点地址'),
            'sort' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(50)->comment('排序凭证'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('创建时间'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('修改时间'),
        ], 'engine=innodb charset=utf8mb4');

        $this->createIndex(
            'idx-friend-sort',
            static::TBL_NAME,
            'sort'

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
        echo "m180924_091728_create_friend_tbl cannot be reverted.\n";

        return false;
    }
    */
}
