<?php 

class SigninCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
    }

    public function loginSuccessfully(AcceptanceTester $I)
    {
        $I->amOnPage('/login');
        $I->fillField('Username','davert');
        $I->fillField('Password','qwerty');
        $I->click('Login');
        $I->see('Hello, davert');
    }

    public  function UserIs(AcceptanceTester $I){
        $I -> iMUser;
        $I -> iClick();
        $I -> canSee();
    }
}
