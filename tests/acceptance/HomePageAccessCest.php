<?php

namespace App\Tests;

class HomePageAccessCest
{
    public function itIsAccessible(AcceptanceTester $I): void
    {
        $I->amOnPage('/');
        $I->see('Quena', 'title');
    }
}
