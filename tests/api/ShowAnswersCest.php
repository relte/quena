<?php

namespace App\Tests;

use Codeception\Util\HttpCode;

class ShowAnswersCest
{
    const FIRST_QUESTION = 'How can you find an answer in Quena?';
    const FIRST_ANSWER_CONTENT = 'Type a phrase you are looking for and click the "Search" button.';

    const SECOND_QUESTION = 'How can you find an answer?';
    const SECOND_ANSWER_CONTENT = 'Google it.';

    const THIRD_QUESTION = 'How do you emphasize a phrase in Markdown?';
    const THIRD_ANSWER_CONTENT = 'To _emphasize_ wrap a phrase with single underscores.';

    public function _before(ApiTester $I): void
    {
        $I->persistAnswer(self::FIRST_QUESTION, self::FIRST_ANSWER_CONTENT);
        $I->persistAnswer(self::SECOND_QUESTION, self::SECOND_ANSWER_CONTENT);
        $I->persistAnswer(self::THIRD_QUESTION, self::THIRD_ANSWER_CONTENT);
        $I->haveHttpHeader('Accept', 'application/json');
    }

    public function showAnswers(ApiTester $I): void
    {
        $I->sendGET('/answers');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();;
        $I->seeJsonResponseEquals([
            [
                'id' => 1,
                'question' => self::FIRST_QUESTION,
                'content' => self::FIRST_ANSWER_CONTENT
            ],
            [
                'id' => 2,
                'question' => self::SECOND_QUESTION,
                'content' => self::SECOND_ANSWER_CONTENT
            ],
            [
                'id' => 3,
                'question' => self::THIRD_QUESTION,
                'content' => self::THIRD_ANSWER_CONTENT
            ]
        ]);
    }

    public function searchForAnswers(ApiTester $I): void
    {
        $I->sendGET('/answers?question=emphasize');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeJsonResponseEquals([
            [
                'id' => 3,
                'question' => self::THIRD_QUESTION,
                'content' => self::THIRD_ANSWER_CONTENT
            ]
        ]);
    }
}
