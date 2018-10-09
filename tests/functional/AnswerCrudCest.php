<?php

namespace App\Tests;

use App\Entity\Answer;

class AnswerCrudCest
{
    const FIRST_QUESTION = 'How can you find an answer in Quena?';
    const FIRST_ANSWER_CONTENT = 'Type a phrase you are looking for and click the "Search" button.';

    const SECOND_QUESTION = 'How can you find an answer?';
    const SECOND_ANSWER_CONTENT = 'Google it.';

    public function itShowsAnswers(FunctionalTester $I): void
    {
        $firstAnswer = new Answer();
        $firstAnswer->setQuestion(self::FIRST_QUESTION);
        $firstAnswer->setContent(self::FIRST_ANSWER_CONTENT);
        $I->persistEntity($firstAnswer);

        $secondAnswer = new Answer();
        $secondAnswer->setQuestion(self::SECOND_QUESTION);
        $secondAnswer->setContent(self::SECOND_ANSWER_CONTENT);
        $I->persistEntity($secondAnswer);

        $I->amOnPage('/answers');
        $I->see(self::FIRST_QUESTION);
        $I->see(self::FIRST_ANSWER_CONTENT);
        $I->see(self::SECOND_QUESTION);
        $I->see(self::SECOND_ANSWER_CONTENT);
    }

    public function itCreatesANewAnswer(FunctionalTester $I): void
    {
        $I->amOnPage('/answers/new');
        $I->fillField('Question', self::FIRST_QUESTION);
        $I->fillField('Content', self::FIRST_ANSWER_CONTENT);
        $I->click('Save');
        $I->see(self::FIRST_QUESTION);
        $I->see(self::FIRST_ANSWER_CONTENT);
    }

    public function itEditsAnAnswer(FunctionalTester $I): void
    {
        $firstAnswer = new Answer();
        $firstAnswer->setQuestion(self::FIRST_QUESTION);
        $firstAnswer->setContent(self::FIRST_ANSWER_CONTENT);
        $I->persistEntity($firstAnswer);

        $I->amOnPage('/answers');
        $I->see(self::FIRST_QUESTION);
        $I->see(self::FIRST_ANSWER_CONTENT);

        $I->click('edit');
        $I->fillField('Question', self::SECOND_QUESTION);
        $I->fillField('Content', self::SECOND_ANSWER_CONTENT);
        $I->click('Update');

        $I->cantSee(self::FIRST_QUESTION);
        $I->cantSee(self::FIRST_ANSWER_CONTENT);

        $I->see(self::SECOND_QUESTION);
        $I->see(self::SECOND_ANSWER_CONTENT);
    }

    public function itDeletesAnAnswer(FunctionalTester $I): void
    {
        $firstAnswer = new Answer();
        $firstAnswer->setQuestion(self::FIRST_QUESTION);
        $firstAnswer->setContent(self::FIRST_ANSWER_CONTENT);
        $I->persistEntity($firstAnswer);

        $I->amOnPage('/answers');
        $I->click('Delete');

        $I->cantSee(self::FIRST_QUESTION);
        $I->cantSee(self::FIRST_ANSWER_CONTENT);
    }
}
