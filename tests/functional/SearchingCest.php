<?php

namespace App\Tests;

use App\Entity\Answer;

class SearchingCest
{
    const FIRST_QUESTION = 'How can you find an answer in Quena?';
    const FIRST_ANSWER_CONTENT = 'Type a phrase you are looking for and click the "Search" button.';

    const SECOND_QUESTION = 'How can you find an answer?';
    const SECOND_ANSWER_CONTENT = 'Google it.';

    const THIRD_QUESTION = 'How do you emphasize a phrase in Markdown?';
    const THIRD_ANSWER_CONTENT = 'To _emphasize_ wrap a phrase with single underscores.';

    public function _before(FunctionalTester $I): void
    {
        $I->persistAnswer(self::FIRST_QUESTION, self::FIRST_ANSWER_CONTENT);
        $I->persistAnswer(self::SECOND_QUESTION, self::SECOND_ANSWER_CONTENT);
        $I->persistAnswer(self::THIRD_QUESTION, self::THIRD_ANSWER_CONTENT);
    }

    public function itShowsAnswersForTheSearchedPhrase(FunctionalTester $I): void
    {
        $I->searchForAnswer('find an answer');

        $I->see(self::FIRST_QUESTION);
        $I->see(self::FIRST_ANSWER_CONTENT);

        $I->see(self::SECOND_QUESTION);
        $I->see(self::SECOND_ANSWER_CONTENT);
    }

    public function itShowsAnswersWithMarkdownParsed(FunctionalTester $I): void
    {
        $I->searchForAnswer('Markdown');
        $I->seeInSource('To <em>emphasize</em> wrap a phrase with single underscores.');
    }
}
