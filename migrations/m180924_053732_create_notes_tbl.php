<?php

use yii\db\Migration;

/**
 * Class m180924_053732_create_notes_tbl
 */
class m180924_053732_create_notes_tbl extends Migration
{
    const TBL_NAME = '{{%notes}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(static::TBL_NAME, [
            'id' => $this->primaryKey()->unsigned()->comment('主键'),
            'title' => $this->string(125)->notNull()->defaultValue('')->comment('日记标题'),
            'content' => $this->text()->comment('日记内容'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('创建时间'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('修改时间'),
            'user_id' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('作者'),
        ], 'engine=innodb charset=utf8mb4');

        $this->createIndex(
            'idx-notes-created_at',
            static::TBL_NAME,
            'created_at'
        );
        $this->createIndex(
            'idx-notes-updated_at',
            static::TBL_NAME,
            'updated_at'
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
        echo "m180924_053732_create_notes_tbl cannot be reverted.\n";

        return false;
    }
    */
}
