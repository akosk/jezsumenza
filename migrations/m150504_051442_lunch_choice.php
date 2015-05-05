<?php

use yii\db\Schema;
use yii\db\Migration;

class m150504_051442_lunch_choice extends Migration
{
    public function up()
    {
        $q = "CREATE TABLE `lunch_choice` (
  `user_id` int(11) NOT NULL,
  `lunch_menu_id` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `user_selected` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`lunch_menu_id`),
  KEY `lunch_menu_id` (`lunch_menu_id`),
  CONSTRAINT `lunch_choice_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `lunch_choice_ibfk_2` FOREIGN KEY (`lunch_menu_id`) REFERENCES `lunch_menu` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;";

        $this->execute($q);
    }

    public function down()
    {
        $this->execute('DROP TABLE  `lunch_choice`');
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
