<?php

namespace App\Tests;

use Codeception\Util\HttpCode;

class AnswersApiCest
{
    const FIRST_ENTRY = 'How can you find an answer in Quena?';
    const FIRST_ANSWER_CONTENT = 'Type a phrase you are looking for and click the "Search" button.';

    const SECOND_ENTRY = 'How can you find an answer?';
    const SECOND_ANSWER_CONTENT = 'Google it.';

    const THIRD_ENTRY = 'How do you emphasize a phrase in Markdown?';
    const THIRD_ANSWER_CONTENT = 'To _emphasize_ wrap a phrase with single underscores.';

    public function _before(ApiTester $I): void
    {
        $I->persistAnswer(self::FIRST_ENTRY, self::FIRST_ANSWER_CONTENT);
        $I->persistAnswer(self::SECOND_ENTRY, self::SECOND_ANSWER_CONTENT);
        $I->persistAnswer(self::THIRD_ENTRY, self::THIRD_ANSWER_CONTENT);
        $I->haveHttpHeader('Accept', 'application/json');
    }

    public function itReturnsAnswerCollection(ApiTester $I): void
    {
        $I->sendGET('/answers');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();;
        $I->seeJsonResponseEquals([
            [
                'id' => 1,
                'entry' => self::FIRST_ENTRY,
                'content' => self::FIRST_ANSWER_CONTENT
            ],
            [
                'id' => 2,
                'entry' => self::SECOND_ENTRY,
                'content' => self::SECOND_ANSWER_CONTENT
            ],
            [
                'id' => 3,
                'entry' => self::THIRD_ENTRY,
                'content' => self::THIRD_ANSWER_CONTENT
            ]
        ]);
    }

    public function itFiltersAnswersWithEntryPhrase(ApiTester $I): void
    {
        $I->sendGET('/answers?entry=emphasize');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeJsonResponseEquals([
            [
                'id' => 3,
                'entry' => self::THIRD_ENTRY,
                'content' => self::THIRD_ANSWER_CONTENT
            ]
        ]);
    }

    public function itSupportsOnlyGetOperations(ApiTester $I): void
    {
        $I->sendPOST('/answers');
        $I->seeResponseCodeIs(HttpCode::METHOD_NOT_ALLOWED);

        $I->sendPUT('/answers/1');
        $I->seeResponseCodeIs(HttpCode::METHOD_NOT_ALLOWED);

        $I->sendDELETE('/answers/1');
        $I->seeResponseCodeIs(HttpCode::METHOD_NOT_ALLOWED);
    }
}
