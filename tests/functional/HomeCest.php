<?php

namespace App\Tests;

class HomeCest
{
    public function itIsTitledWithTheApplicationName(FunctionalTester $I): void
    {
        $I->amOnPage('/');
        $I->canSee('Quena', 'title');
        $I->canSee('Quena', 'h1');
    }

    public function itHasASearchFormToFindQuestionsWithAnswers(FunctionalTester $I): void
    {
        $I->amOnPage('/');
        $I->canSeeElement('form');
        $I->canSeeElement('form > input');
        $I->canSeeElement('form > button[type="submit"]');
    }
}
