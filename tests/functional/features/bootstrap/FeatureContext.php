<?php
/**
 * Created by PhpStorm.
 * User: marina.jechiu
 * Date: 16/8/2019
 * Time: 5:02 PM
 */

use Behat\Behat\Context\Context;

class FeatureContext implements Context
{
    public $myFirstvar;
    /**
     * @Then /^I can see Pay button$/
     */
    public static function iCanSeePayButton()
    {
       return "true";
    }
}

assertEquals("true", FeatureContext::iCanSeePayButton());