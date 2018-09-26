<?php

use yii\db\Migration;

/**
 * Class m180924_101336_create_user_tbl
 */
class m180924_101336_create_user_tbl extends Migration
{
    const TBL_NAME = '{{%user}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TBL_NAME, [
            'id'        => $this->primaryKey()->unsigned()->comment('主键'),
            'username'  => $this->string(18)->notNull()->unique()->defaultValue('')->comment('用户名'),
            'email'     => $this->string(64)->notNull()->unique()->defaultValue('')->comment('邮箱'),
            'image'     => $this->string(64)->notNull()->defaultValue('')->comment('头像'),
            'status'    => $this->tinyInteger()->unsigned()->notNull()->defaultValue(10)->comment('状态'),
            'auth_key'  => $this->string()->notNull()->defaultValue('')->comment('Auth_Key'),
            'password_hash' => $this->string()->notNull()->defaultValue('')->comment('密码'),
            'password_reset_token' => $this->string()->notNull()->defaultValue('')->comment('密码重置key'),
            //'qqopenid'  => $this->string()->notNull()->defaultValue('')->comment('qq登陆'),
            //'wxopenid'  => $this->string()->notNull()->defaultValue('')->comment('wx登陆'),
            'created_at'=> $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('注册时间'),
            'updated_at'=> $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('修改时间'),
            'lasttime'  => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('最后登录时间'),
            'signip'   => $this->bigInteger()->unsigned()->notNull()->defaultValue(0)->comment('最后登录ip')
        ], 'engine=innodb default charset=utf8');

        //创建索引
        $this->createIndex(
            'idx-user-auth_key',
            self::TBL_NAME,
            'auth_key'
        );
        $this->createIndex(
            'idx-user-password_hash',
            self::TBL_NAME,
            'password_hash'
        );
        $this->createIndex(
            'idx-user-password_reset_token',
            self::TBL_NAME,
            'password_reset_token'
        );
        $this->createIndex(//+
            'idx-user-created_at',
            self::TBL_NAME,
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
        echo "m180924_101336_create_user_tbl cannot be reverted.\n";

        return false;
    }
    */
}
