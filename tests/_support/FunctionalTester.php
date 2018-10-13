<?php
namespace App\Tests;

use App\Entity\Answer;

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
class FunctionalTester extends \Codeception\Actor
{
    use _generated\FunctionalTesterActions;

    public function persistAnswer(string $entry, string $content): void
    {
        $answer = new Answer();
        $answer->setEntry($entry);
        $answer->setContent($content);
        $this->persistEntity($answer);
    }

    public function searchForAnswer(string $phrase): void
    {
        $this->amOnPage('/');
        $this->fillField(['name' => 'search'], $phrase);
        $this->click('#search');
    }
}
