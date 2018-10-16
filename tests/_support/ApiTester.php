<?php
namespace App\Tests;

use App\Entity\Entry;

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
class ApiTester extends \Codeception\Actor
{
    use _generated\ApiTesterActions;

    public function persistEntry(string $name, string $content): void
    {
        $entry = new Entry();
        $entry->setTitle($name);
        $entry->setContent($content);
        $this->persistEntity($entry);
    }

    public function seeJsonResponseEquals(array $expected): void
    {
        $this->seeResponseEquals(json_encode($expected));
    }
}
