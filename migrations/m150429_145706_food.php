<?php

use yii\db\Schema;
use yii\db\Migration;

class m150429_145706_food extends Migration
{
    public function up()
    {
        $q="CREATE TABLE `food` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` enum('MAIN_COURSE','SOUP') COLLATE utf8_hungarian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;";
        $this->execute($q);

        $this->createTable('{{%food_translation}}', [
            'food_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'language' => Schema::TYPE_STRING . '(16) NOT NULL',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'description' => Schema::TYPE_TEXT . ' NOT NULL',
        ]);

        $this->addPrimaryKey('', '{{%food_translation}}', ['food_id', 'language']);

    }

    public function down()
    {
        $this->execute('DROP TABLE  `food`');
    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
