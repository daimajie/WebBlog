<?php

use yii\db\Migration;

/**
 * Class m181001_132849_create_contact_tbl
 */
class m181001_132849_create_contact_tbl extends Migration
{
    const TBL_NAME = '{{%contact}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(static::TBL_NAME, [
            'id' => $this->primaryKey()->unsigned()->comment('主键'),
            'email' => $this->string(64)->notNull()->defaultValue('')->comment('联系邮箱'),
            'subject' => $this->string(125)->notNull()->defaultValue('')->comment('信息主题'),
            'body' => $this->string(512)->notNull()->defaultValue('')->comment('信息主体'),
            'visited' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0)->comment('阅读状态'),
            'user_id' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('用户'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('创建时间'),
        ], 'engine=innodb charset=utf8mb4');

        $this->createIndex(
            'idx-contact-user_id',
            static::TBL_NAME,
            'user_id'
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
        echo "m181001_132849_create_contact_tbl cannot be reverted.\n";

        return false;
    }
    */
}
