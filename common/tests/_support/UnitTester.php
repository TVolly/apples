<?php
namespace common\tests;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
 */
class UnitTester extends \Codeception\Actor
{
    use _generated\UnitTesterActions;
   /**
    * Define custom actions here
    */

    public function expectException($callback, $exceptionClass)
    {
        $validException = false;
        try {
            $callback();
        } catch (\Exception $e) {
            $validException = is_a($e, $exceptionClass);
        }
        expect('fall exception', $validException)->true();
    }
}
