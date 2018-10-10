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
        $I->persistAnswer(self::FIRST_QUESTION, self::FIRST_ANSWER_CONTENT);
        $I->persistAnswer(self::SECOND_QUESTION, self::SECOND_ANSWER_CONTENT);

        $I->amOnPage('/answers');
        $I->see(self::FIRST_QUESTION);
        $I->see(self::FIRST_ANSWER_CONTENT);
        $I->see(self::SECOND_QUESTION);
        $I->see(self::SECOND_ANSWER_CONTENT);
    }

    public function itShowsAnAnswerWithMarkdownParsed(FunctionalTester $I): void
    {
        $I->persistAnswer(
            'How do you emphasize a phrase in Markdown?',
            'To _emphasize_ wrap a phrase with single underscores.'
        );

        $I->amOnPage('/answers');
        $I->seeInSource('To <em>emphasize</em> wrap a phrase with single underscores.');
    }

    public function itCreatesANewAnswer(FunctionalTester $I): void
    {
        $I->amOnPage('/answers/new');
        $I->fillField('Question', self::FIRST_QUESTION);
        $I->fillField('Content', self::FIRST_ANSWER_CONTENT);
        $I->click('#save_answer');
        $I->see(self::FIRST_QUESTION);
        $I->see(self::FIRST_ANSWER_CONTENT);
    }

    public function itEditsAnAnswer(FunctionalTester $I): void
    {
        $I->persistAnswer(self::FIRST_QUESTION, self::FIRST_ANSWER_CONTENT);

        $I->amOnPage('/answers');
        $I->see(self::FIRST_QUESTION);
        $I->see(self::FIRST_ANSWER_CONTENT);

        $I->click('#edit_answer_1');
        $I->fillField('Question', self::SECOND_QUESTION);
        $I->fillField('Content', self::SECOND_ANSWER_CONTENT);
        $I->click('#save_answer');

        $I->cantSee(self::FIRST_QUESTION);
        $I->cantSee(self::FIRST_ANSWER_CONTENT);

        $I->see(self::SECOND_QUESTION);
        $I->see(self::SECOND_ANSWER_CONTENT);
    }

    public function itDeletesAnAnswer(FunctionalTester $I): void
    {
        $I->persistAnswer(self::FIRST_QUESTION, self::FIRST_ANSWER_CONTENT);

        $I->amOnPage('/answers');
        $I->click('#delete_answer_1');

        $I->cantSee(self::FIRST_QUESTION);
        $I->cantSee(self::FIRST_ANSWER_CONTENT);
    }
}
