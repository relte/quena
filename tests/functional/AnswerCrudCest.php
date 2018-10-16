<?php

namespace App\Tests;

use Codeception\Util\HttpCode;

class EntryCrudCest
{
    const FIRST_ENTRY_TITLE = 'How can you find an entry in Quena?';
    const FIRST_ENTRY_CONTENT = 'Type a phrase you are looking for and click the "Search" button.';

    const SECOND_ENTRY_TITLE = 'How can you find an entry?';
    const SECOND_ENTRY_CONTENT = 'Google it.';

    public function itShowsEntries(FunctionalTester $I): void
    {
        $I->amHttpAuthenticated('admin', 'admin');
        $I->persistEntry(self::FIRST_ENTRY_TITLE, self::FIRST_ENTRY_CONTENT);
        $I->persistEntry(self::SECOND_ENTRY_TITLE, self::SECOND_ENTRY_CONTENT);

        $I->amOnPage('/entries');
        $I->see(self::FIRST_ENTRY_TITLE);
        $I->see(self::FIRST_ENTRY_CONTENT);
        $I->see(self::SECOND_ENTRY_TITLE);
        $I->see(self::SECOND_ENTRY_CONTENT);
    }

    public function itShowsAnEntryWithMarkdownParsed(FunctionalTester $I): void
    {
        $I->amHttpAuthenticated('admin', 'admin');
        $I->persistEntry(
            'How do you emphasize a phrase in Markdown?',
            'To _emphasize_ wrap a phrase with single underscores.'
        );

        $I->amOnPage('/entries');
        $I->seeInSource('To <em>emphasize</em> wrap a phrase with single underscores.');
    }

    public function itCreatesANewEntry(FunctionalTester $I): void
    {
        $I->amHttpAuthenticated('admin', 'admin');
        $I->amOnPage('/entries/new');
        $I->fillField('Title', self::FIRST_ENTRY_TITLE);
        $I->fillField('Content', self::FIRST_ENTRY_CONTENT);
        $I->click('#save_entry');
        $I->see(self::FIRST_ENTRY_TITLE);
        $I->see(self::FIRST_ENTRY_CONTENT);
    }

    public function itValidatesTitleWhenCreatingANewEntry(FunctionalTester $I): void
    {
        $this->testValidationWith($I, '', self::FIRST_ENTRY_CONTENT, 'This value should not be blank.');

        $tooLongEntryTitle = str_repeat('a', 256);
        $this->testValidationWith($I, $tooLongEntryTitle, self::FIRST_ENTRY_CONTENT, 'This value is too long. It should have 255 characters or less.');
    }

    public function itValidatesContentWhenCreatingANewEntry(FunctionalTester $I): void
    {
        $this->testValidationWith($I, self::FIRST_ENTRY_TITLE, '', 'This value should not be blank.');

        $tooLongEntryContent = str_repeat('a', 1001);
        $this->testValidationWith($I, self::FIRST_ENTRY_TITLE, $tooLongEntryContent, 'This value is too long. It should have 1000 characters or less.');
    }

    private function testValidationWith(FunctionalTester $I, $name, $content, $errorMessage): void
    {
        $I->amHttpAuthenticated('admin', 'admin');
        $I->amOnPage('/entries/new');
        $I->fillField('Title', $name);
        $I->fillField('Content', $content);
        $I->click('#save_entry');
        $I->canSee($errorMessage);
        $I->amOnPage('/entries');
        $I->cantSee(self::FIRST_ENTRY_TITLE);
    }

    public function itEditsAnEntry(FunctionalTester $I): void
    {
        $I->amHttpAuthenticated('admin', 'admin');
        $I->persistEntry(self::FIRST_ENTRY_TITLE, self::FIRST_ENTRY_CONTENT);

        $I->amOnPage('/entries');
        $I->see(self::FIRST_ENTRY_TITLE);
        $I->see(self::FIRST_ENTRY_CONTENT);

        $I->click('#edit_entry_1');
        $I->fillField('Title', self::SECOND_ENTRY_TITLE);
        $I->fillField('Content', self::SECOND_ENTRY_CONTENT);
        $I->click('#save_entry');

        $I->cantSee(self::FIRST_ENTRY_TITLE);
        $I->cantSee(self::FIRST_ENTRY_CONTENT);

        $I->see(self::SECOND_ENTRY_TITLE);
        $I->see(self::SECOND_ENTRY_CONTENT);
    }

    public function itDeletesAnEntry(FunctionalTester $I): void
    {
        $I->amHttpAuthenticated('admin', 'admin');
        $I->persistEntry(self::FIRST_ENTRY_TITLE, self::FIRST_ENTRY_CONTENT);

        $I->amOnPage('/entries');
        $I->click('#delete_entry_1');

        $I->cantSee(self::FIRST_ENTRY_TITLE);
        $I->cantSee(self::FIRST_ENTRY_CONTENT);
    }

    public function itPreventsAccessToNotAuthenticatedUser(FunctionalTester $I): void
    {
        $I->persistEntry(self::FIRST_ENTRY_TITLE, self::FIRST_ENTRY_CONTENT);

        $I->amOnPage('/entries');
        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);

        $I->amOnPage('/entries/new');
        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);

        $I->amOnPage('/entries/1/edit');
        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
    }
}
