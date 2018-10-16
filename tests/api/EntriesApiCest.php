<?php

namespace App\Tests;

use Codeception\Util\HttpCode;

class EntriesApiCest
{
    const FIRST_ENTRY_TITLE = 'How can you find an entry in Quena?';
    const FIRST_ENTRY_CONTENT = 'Type a phrase you are looking for and click the "Search" button.';

    const SECOND_ENTRY_TITLE = 'How can you find an entry?';
    const SECOND_ENTRY_CONTENT = 'Google it.';

    const THIRD_ENTRY_TITLE = 'How do you emphasize a phrase in Markdown?';
    const THIRD_ENTRY_CONTENT = 'To _emphasize_ wrap a phrase with single underscores.';

    public function _before(ApiTester $I): void
    {
        $I->persistEntry(self::FIRST_ENTRY_TITLE, self::FIRST_ENTRY_CONTENT);
        $I->persistEntry(self::SECOND_ENTRY_TITLE, self::SECOND_ENTRY_CONTENT);
        $I->persistEntry(self::THIRD_ENTRY_TITLE, self::THIRD_ENTRY_CONTENT);
        $I->haveHttpHeader('Accept', 'application/json');
    }

    public function itReturnsEntryCollection(ApiTester $I): void
    {
        $I->sendGET('/entries');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();;
        $I->seeJsonResponseEquals([
            [
                'id' => 1,
                'title' => self::FIRST_ENTRY_TITLE,
                'content' => self::FIRST_ENTRY_CONTENT
            ],
            [
                'id' => 2,
                'title' => self::SECOND_ENTRY_TITLE,
                'content' => self::SECOND_ENTRY_CONTENT
            ],
            [
                'id' => 3,
                'title' => self::THIRD_ENTRY_TITLE,
                'content' => self::THIRD_ENTRY_CONTENT
            ]
        ]);
    }

    public function itFiltersEntriesWithTitlePart(ApiTester $I): void
    {
        $I->sendGET('/entries?title=emphasize');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeJsonResponseEquals([
            [
                'id' => 3,
                'title' => self::THIRD_ENTRY_TITLE,
                'content' => self::THIRD_ENTRY_CONTENT
            ]
        ]);
    }

    public function itSupportsOnlyGetOperations(ApiTester $I): void
    {
        $I->sendPOST('/entries');
        $I->seeResponseCodeIs(HttpCode::METHOD_NOT_ALLOWED);

        $I->sendPUT('/entries/1');
        $I->seeResponseCodeIs(HttpCode::METHOD_NOT_ALLOWED);

        $I->sendDELETE('/entries/1');
        $I->seeResponseCodeIs(HttpCode::METHOD_NOT_ALLOWED);
    }
}
