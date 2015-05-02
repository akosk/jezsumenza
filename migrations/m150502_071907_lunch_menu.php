<?php

use yii\db\Schema;
use yii\db\Migration;

class m150502_071907_lunch_menu extends Migration
{
    public function up()
    {
        $q = "CREATE TABLE `lunch_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `letter` char(1) COLLATE utf8_hungarian_ci NOT NULL,
  `date` date NOT NULL,
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;
";
        $this->execute($q);
        $q="CREATE TABLE `lunch_menu_food` (
  `lunch_menu_id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  PRIMARY KEY (`lunch_menu_id`,`food_id`),
  KEY `food_id` (`food_id`),
  CONSTRAINT `lunch_menu_food_ibfk_2` FOREIGN KEY (`lunch_menu_id`) REFERENCES `lunch_menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `lunch_menu_food_ibfk_1` FOREIGN KEY (`food_id`) REFERENCES `food` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;";
        $this->execute($q);
    }

    public function down()
    {
        $this->execute('DROP TABLE  `lunch_menu_food`');
        $this->execute('DROP TABLE  `lunch_menu`');
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
