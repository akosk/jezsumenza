<?php

use yii\db\Schema;
use yii\db\Migration;

class m150422_050120_ArChangeLoggerBehavior extends Migration
{
    public function up()
    {
        $q="CREATE TABLE `ar_change_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action_hash` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `editor_id` int(11) DEFAULT NULL,
  `classname` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `item_id` int(11) NOT NULL,
  `property` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `old_value` text COLLATE utf8_hungarian_ci,
  `new_value` text COLLATE utf8_hungarian_ci,
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `editor_id` (`editor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;";
        $this->execute($q);

        $q="CREATE TABLE `test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_hungarian_ci DEFAULT NULL,
  `value` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;";

        $this->execute($q);
    }

    public function down()
    {
        $this->execute('DROP TABLE  ar_change_log');

        return false;
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
