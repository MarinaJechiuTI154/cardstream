<?php
/**
 * Created by PhpStorm.
 * User: marina.jechiu
 * Date: 19/8/2019
 * Time: 12:05 PM
 */

use Behat\Behat\Context\Context;

class AcceptanceContext implements Context
{
    /**
     * @Then /^I see$/
     */

    public function iSee()
    {
        throw new \Behat\Behat\Tester\Exception\PendingException();
    }

    /**
     * @When /^I click$/
     */
    public function iClick()
    {
        throw new \Behat\Behat\Tester\Exception\PendingException();
    }

    /**
     * @Given /^I'm user$/
     */
    public function iMUser()
    {
        throw new \Behat\Behat\Tester\Exception\PendingException();
    }
}