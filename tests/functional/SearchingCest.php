<?php

namespace App\Tests;

use App\Entity\Answer;

class SearchingCest
{
    const FIRST_QUESTION = 'How can you find an answer in Quena?';
    const FIRST_ANSWER_CONTENT = 'Type a phrase you are looking for and click the "Search" button.';

    const SECOND_QUESTION = 'How can you find an answer?';
    const SECOND_ANSWER_CONTENT = 'Google it.';

    public function _before(FunctionalTester $I): void
    {
        $firstAnswer = new Answer();
        $firstAnswer->setQuestion(self::FIRST_QUESTION);
        $firstAnswer->setContent(self::FIRST_ANSWER_CONTENT);
        $I->persistEntity($firstAnswer);

        $secondAnswer = new Answer();
        $secondAnswer->setQuestion(self::SECOND_QUESTION);
        $secondAnswer->setContent(self::SECOND_ANSWER_CONTENT);
        $I->persistEntity($secondAnswer);
    }

    public function itDisplaysAnswersForTheSearchedPhrase(FunctionalTester $I): void
    {
        $I->amOnPage('/');
        $I->fillField(['name' => 'search'], 'find an answer');
        $I->click('Search');

        $I->see(self::FIRST_QUESTION);
        $I->see(self::FIRST_ANSWER_CONTENT);

        $I->see(self::SECOND_QUESTION);
        $I->see(self::SECOND_ANSWER_CONTENT);
    }
}
