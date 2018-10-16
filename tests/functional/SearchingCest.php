<?php

namespace App\Tests;

class SearchingCest
{
    const FIRST_ENTRY_TITLE = 'How can you find an entry in Quena?';
    const FIRST_ENTRY_CONTENT = 'Type a phrase you are looking for and click the "Search" button.';

    const SECOND_ENTRY_TITLE = 'How can you find an entry?';
    const SECOND_ENTRY_CONTENT = 'Google it.';

    const THIRD_ENTRY_TITLE = 'How do you emphasize a phrase in Markdown?';
    const THIRD_ENTRY_CONTENT = 'To _emphasize_ wrap a phrase with single underscores.';

    public function _before(FunctionalTester $I): void
    {
        $I->persistEntry(self::FIRST_ENTRY_TITLE, self::FIRST_ENTRY_CONTENT);
        $I->persistEntry(self::SECOND_ENTRY_TITLE, self::SECOND_ENTRY_CONTENT);
        $I->persistEntry(self::THIRD_ENTRY_TITLE, self::THIRD_ENTRY_CONTENT);
    }

    public function itShowsEntriesForTheSearchedPhrase(FunctionalTester $I): void
    {
        $I->searchForEntry('find an entry');

        $I->see(self::FIRST_ENTRY_TITLE);
        $I->see(self::FIRST_ENTRY_CONTENT);

        $I->see(self::SECOND_ENTRY_TITLE);
        $I->see(self::SECOND_ENTRY_CONTENT);
    }

    public function itShowsEntriesWithMarkdownParsed(FunctionalTester $I): void
    {
        $I->searchForEntry('Markdown');
        $I->seeInSource('To <em>emphasize</em> wrap a phrase with single underscores.');
    }
}
