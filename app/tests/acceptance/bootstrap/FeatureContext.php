<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
use Behat\Mink\Exception\ExpectationException;
use Behat\MinkExtension\Context\MinkContext;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends MinkContext
{
    /**
     * Initializes context.
     * Every scenario gets its own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        // Initialize your context here
    }

    /**
     * @static
     * @beforeSuite
     */
    public static function bootstrapLaravel(){
        $unitTesting = true;
        $testEnvironment = 'testing';
    }



//
// Place your definition and hook methods here:
//
//    /**
//     * @Given /^I have done something with "([^"]*)"$/
//     */
//    public function iHaveDoneSomethingWith($argument)
//    {
//        doSomethingWith($argument);
//    }
//

    /**
     * @Given /^I am authenticated as "([^"]*)"$/
     */
    public function iAmAuthenticatedAs($username)
    {
        $this->visit('/auth/login');
        $this->fillField('email', 'hall.jake.a@gmail.com');
        $this->fillField('password', 'password');
        $this->pressButton('Login');
    }

    /**
     * @Given /^I should see the field "([^"]*)" filled with "([^"]*)"$/
     */
    public function iShouldSeeTheFieldFilledWith($field, $expected)
    {
        $field = $this->getSession()->getPage()->findField($field);
        $actual = $field->getValue();

        if($actual != $expected){
            $message = sprintf('Field is "%s", but "%s" expected.', $actual, $expected);
            throw new ExpectationException($message, $this->getSession());
        }
    }


}
