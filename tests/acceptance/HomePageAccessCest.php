<?php

namespace App\Tests;

class HomePageAccessCest
{
    public function homepageWorks(AcceptanceTester $I): void
    {
        $I->amOnPage('/');
        $I->see('Quena', 'title');
    }
}
