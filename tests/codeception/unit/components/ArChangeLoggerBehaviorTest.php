<?php

namespace tests\codeception\unit\components;

use yii\base\Component;
use yii\codeception\TestCase;
use app\components\ArChangeLoggerBehavior;
use Codeception\Specify;
use yii\db\ActiveRecord;

class ArChangeLoggerBehaviorTest extends TestCase
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
            $logger = new ArChangeLoggerBehavior();
            expect('Class exists', $logger)->notNull();
        });
    }

    public function testInsert()
    {
// TODO: NOT WORK!

        $logger = new ArChangeLoggerBehavior();

        $userMock = $this->getMockBuilder('app\components\ArChangeLoggerBehavior')->setMethods(['save'])->getMock();
        $userMock->expects($this->once())->method('save')->will($this->returnCallback(function () { return 'model_is_saved'; }));
        $this->assertEquals('model_is_saved', $userMock->save());

//        $component = new Component;

//        $arChangeLog = $this->getMock("ArChangeLog");
//        $arChangeLog=$this->getMockBuilder("ArChangeLog")
//            ->setMethods(array("getIsNewRecord", "save"))
//            ->disableOriginalConstructor()
//            ->getMock();

//        $arChangeLog->attachBehavior('ArChangeLoggerBehavior', $logger);

//        $logger->attach($component);
//        $component->trigger(ActiveRecord::EVENT_AFTER_INSERT);

    }
}
