<?php

namespace App\Tests;

use Codeception\Util\HttpCode;

class AnswerCrudCest
{
    const FIRST_ENTRY = 'How can you find an answer in Quena?';
    const FIRST_ANSWER_CONTENT = 'Type a phrase you are looking for and click the "Search" button.';

    const SECOND_ENTRY = 'How can you find an answer?';
    const SECOND_ANSWER_CONTENT = 'Google it.';

    public function itShowsAnswers(FunctionalTester $I): void
    {
        $I->amHttpAuthenticated('admin', 'admin');
        $I->persistAnswer(self::FIRST_ENTRY, self::FIRST_ANSWER_CONTENT);
        $I->persistAnswer(self::SECOND_ENTRY, self::SECOND_ANSWER_CONTENT);

        $I->amOnPage('/answers');
        $I->see(self::FIRST_ENTRY);
        $I->see(self::FIRST_ANSWER_CONTENT);
        $I->see(self::SECOND_ENTRY);
        $I->see(self::SECOND_ANSWER_CONTENT);
    }

    public function itShowsAnAnswerWithMarkdownParsed(FunctionalTester $I): void
    {
        $I->amHttpAuthenticated('admin', 'admin');
        $I->persistAnswer(
            'How do you emphasize a phrase in Markdown?',
            'To _emphasize_ wrap a phrase with single underscores.'
        );

        $I->amOnPage('/answers');
        $I->seeInSource('To <em>emphasize</em> wrap a phrase with single underscores.');
    }

    public function itCreatesANewAnswer(FunctionalTester $I): void
    {
        $I->amHttpAuthenticated('admin', 'admin');
        $I->amOnPage('/answers/new');
        $I->fillField('Entry', self::FIRST_ENTRY);
        $I->fillField('Content', self::FIRST_ANSWER_CONTENT);
        $I->click('#save_answer');
        $I->see(self::FIRST_ENTRY);
        $I->see(self::FIRST_ANSWER_CONTENT);
    }

    public function itValidatesEntryWhenCreatingANewAnswer(FunctionalTester $I): void
    {
        $this->testValidationWith($I, '', self::FIRST_ANSWER_CONTENT, 'This value should not be blank.');

        $tooLongEntry = str_repeat('a', 256);
        $this->testValidationWith($I, $tooLongEntry, self::FIRST_ANSWER_CONTENT, 'This value is too long. It should have 255 characters or less.');
    }

    public function itValidatesContentWhenCreatingANewAnswer(FunctionalTester $I): void
    {
        $this->testValidationWith($I, self::FIRST_ENTRY, '', 'This value should not be blank.');

        $tooLongAnswerContent = str_repeat('a', 1001);
        $this->testValidationWith($I, self::FIRST_ENTRY, $tooLongAnswerContent, 'This value is too long. It should have 1000 characters or less.');
    }

    private function testValidationWith(FunctionalTester $I, $entry, $content, $errorMessage): void
    {
        $I->amHttpAuthenticated('admin', 'admin');
        $I->amOnPage('/answers/new');
        $I->fillField('Entry', $entry);
        $I->fillField('Content', $content);
        $I->click('#save_answer');
        $I->canSee($errorMessage);
        $I->amOnPage('/answers');
        $I->cantSee(self::FIRST_ENTRY);
    }

    public function itEditsAnAnswer(FunctionalTester $I): void
    {
        $I->amHttpAuthenticated('admin', 'admin');
        $I->persistAnswer(self::FIRST_ENTRY, self::FIRST_ANSWER_CONTENT);

        $I->amOnPage('/answers');
        $I->see(self::FIRST_ENTRY);
        $I->see(self::FIRST_ANSWER_CONTENT);

        $I->click('#edit_answer_1');
        $I->fillField('Entry', self::SECOND_ENTRY);
        $I->fillField('Content', self::SECOND_ANSWER_CONTENT);
        $I->click('#save_answer');

        $I->cantSee(self::FIRST_ENTRY);
        $I->cantSee(self::FIRST_ANSWER_CONTENT);

        $I->see(self::SECOND_ENTRY);
        $I->see(self::SECOND_ANSWER_CONTENT);
    }

    public function itDeletesAnAnswer(FunctionalTester $I): void
    {
        $I->amHttpAuthenticated('admin', 'admin');
        $I->persistAnswer(self::FIRST_ENTRY, self::FIRST_ANSWER_CONTENT);

        $I->amOnPage('/answers');
        $I->click('#delete_answer_1');

        $I->cantSee(self::FIRST_ENTRY);
        $I->cantSee(self::FIRST_ANSWER_CONTENT);
    }

    public function itPreventsAccessToNotAuthenticatedUser(FunctionalTester $I): void
    {
        $I->persistAnswer(self::FIRST_ENTRY, self::FIRST_ANSWER_CONTENT);

        $I->amOnPage('/answers');
        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);

        $I->amOnPage('/answers/new');
        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);

        $I->amOnPage('/answers/1/edit');
        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
    }
}
