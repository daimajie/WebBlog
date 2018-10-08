<?php

use yii\db\Migration;

/**
 * Class m181001_095839_create_setups_tbl
 */
class m181001_095839_create_setups_tbl extends Migration
{
    const TBL_NAME = '{{%setups}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(static::TBL_NAME, [
            'id' => $this->primaryKey()->unsigned()->comment('主键'),
            'name' => $this->string(12)->notNull()->defaultValue('')->comment('站点名称'),
            'sign' => $this->string(125)->notNull()->defaultValue('')->comment('签名'),
            'keywords' => $this->string(255)->notNull()->defaultValue('')->comment('关键字'),
            'description' => $this->string(512)->notNull()->defaultValue('')->comment('站点描述'),
            'image' => $this->string('128')->notNull()->defaultValue('')->comment('图片'),
            'email' => $this->string(64)->notNull()->defaultValue('')->comment('联系邮箱'),
            'about' => $this->string(512)->notNull()->defaultValue('')->comment('关于我'),
            'history' => $this->text()->comment('我的故事'),
            'created_at' => $this->integer()->notNull()->unsigned()->defaultValue(0)->comment('创建时间'),
            'updated_at' => $this->integer()->notNull()->unsigned()->defaultValue(0)->comment('修改时间'),

        ], 'engine=innodb charset=utf8mb4');

        $this->insert(static::TBL_NAME, [
            'id' => 1,
            'name' => 'web blog',
            'sign' => 'Keep your face to the sunshine, and you cannot see a shadow.',
            'keywords' => 'blog,min blog,web blog.',
            'description' => 'my blog',
            'image' => '/static/img/widget/about.jpg',
            'email' => 'admin@admin.com',
            'about' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remained.',
            'history' => 'my history text',
        ]);


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
        echo "m181001_095839_create_setups_tbl cannot be reverted.\n";

        return false;
    }
    */
}
