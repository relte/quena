<?php

namespace App\Tests;

class HomeControllerCest
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
        $I->canSeeElement('form > input[name="search"]');
        $I->canSeeElement('form > button[type="submit"]');
    }
}
