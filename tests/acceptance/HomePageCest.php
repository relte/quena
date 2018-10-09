<?php

namespace App\Tests;

class HomePageCest
{
    public function homepageWorks(AcceptanceTester $I): void
    {
        $I->amOnPage('/');
        $I->see('Quena', 'title');
    }
}
