<?php

namespace tests\codeception\unit\components;

use yii\codeception\TestCase;
use app\models\ArChangeLog;
use Codeception\Specify;

class ArChangeLogTest extends TestCase
{
    use Specify;

    protected function setUp()
    {
        parent::setUp();
        // uncomment the following to load fixtures for user table
        //$this->loadFixtures(['user']);
    }

    public function testClassExists()
    {
        $this->specify('Test that the class exists ', function () {
            $logger=new ArChangeLog();
            expect('Class exists', $logger)->notNull();
        });
    }

}
