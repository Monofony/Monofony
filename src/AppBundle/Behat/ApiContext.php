<?php

/*
 * This file is part of AppName.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Behat;

use Behat\Gherkin\Node\TableNode;
use Sylius\Component\User\Model\CustomerInterface;

/**
 * @author Loïc Frémont <loic@mobizel.com>
 */
class ApiContext extends DefaultContext
{
    /**
     * @When /^I request "([^"]*)"$/
     */
    public function iRequest($uri)
    {
        $this->makeRequest(sprintf($uri));
    }

    /**
     * @When /^I request "([^"]*)" with "([^"]*)" method$/
     */
    public function iRequestWithMethod($uri, $method)
    {
        $this->makeRequest(sprintf($uri), null, $method);
    }

    /**
     * @When /^I request "([^"]*)" with "([^"]*)" method and following data:$/
     * @param string $uri
     * @param $method
     * @param TableNode $table
     */
    public function iRequestWithMethodAndData($uri, $method, $table)
    {
        $this->makeRequest($uri, null, $method, $table->getHash()[0]);
    }

    /**
     * @When /^I request "([^"]*)" as user "([^"]*)"$/
     */
    public function iRequestAsUser($uri, $email)
    {
        /** @var CustomerInterface $customer */
        $customer = $this->getContainer()
            ->get('sylius.repository.customer')
            ->findOneBy(array('email' => $email));
        $this->makeRequest(sprintf($uri), $customer->getUser());
    }

    /**
     * @When /^I request "([^"]*)" as user "([^"]*)" with "([^"]*)" method and following data:$/
     * @param $uri
     * @param $method
     * @param $email
     * @param TableNode $table
     */
    public function iRequestAsUserWithMethodAndData($uri, $email, $method, TableNode $table)
    {
        /** @var CustomerInterface $customer */
        $customer = $this->getContainer()
            ->get('sylius.repository.customer')
            ->findOneBy(array('email' => $email));
        $this->makeRequest($uri, $customer->getUser(), $method, $table->getHash()[0]);
    }

    /**
     * @Then /^(?:|the )response should be JSON$/
     */
    public function theResponseShouldBeJson()
    {
        $data = json_decode(parent::$response->getBody());
        if (empty($data)) {
            throw new \Exception("Response was not JSON\n" . parent::$response->getBody()->getContents());
        }
    }

    /**
     * @Then /^(?:|the )api response status code should be (\d+)$/
     *
     * @param $httpStatus
     * @throws \Exception
     */
    public function theApiResponseStatusCodeShouldBe($httpStatus)
    {
        if ((string)parent::$lastRequestCode !== $httpStatus) {
            throw new \Exception('HTTP code does not match ' . $httpStatus .
                ' (actual: ' . parent::$lastRequestCode . ')');
        }
    }

    /**
     * @Then /^(?:|the )response is an array containing "([^"]*)" rows$/
     *
     * @param $nbRows
     * @throws \Exception
     */
    public function theResponseIsAnArrayContaining($nbRows)
    {
        $data = json_decode(parent::$response->getBody());
        if (!empty($data)) {
            if (!is_array($data)) {
                throw new \Exception("Response is not an array!\n");
            }

            if ((int)$nbRows !== count($data)) {
                throw new \Exception("The array contains " . count($data) . " but it should contain " . $nbRows . " rows !\n");
            }
        } else {
            throw new \Exception("Response was not JSON\n" . parent::$response->getBody()->getContents());
        }
    }

    /**
     * @Then /^(?:|the )response has a row "([^"]*)" with property "([^"]*)"$/
     *
     * @param $key
     * @param $propertyName
     * @throws \Exception
     */
    public function theResponseHasARowWithProperty($key, $propertyName)
    {
        $data = json_decode(parent::$response->getBody());
        if (!empty($data)) {
            if (!is_array($data)) {
                throw new \Exception("Response is not an array!\n");
            }

            if (!isset($data[$key])) {
                throw new \Exception("The array does not contain row with key " . $key . " but it should\n");
            }

            if (!isset($data[$key]->$propertyName)) {
                throw new \Exception("Property '" . $propertyName . "' does not appear in row with key " . $key . " but it should\n");
            }
        } else {
            throw new \Exception("Response was not JSON\n" . parent::$response->getBody()->getContents());
        }
    }

    /**
     * @Then /^(?:|the )response has a row "([^"]*)" with property "([^"]*)" equals to "([^"]*)"$/
     *
     * @param $key
     * @param $propertyName
     * @param $value
     * @throws \Exception
     */
    public function theResponseHasARowWithPropertyEqualsTo($key, $propertyName, $value)
    {
        $data = json_decode(parent::$response->getBody());
        if (!empty($data)) {
            if (!is_array($data)) {
                throw new \Exception("Response is not an array!\n");
            }

            if (!isset($data[$key])) {
                throw new \Exception("The array does not contain row with key " . $key . " but it should\n");
            }

            if (!isset($data[$key]->$propertyName)) {
                throw new \Exception("Property '" . $propertyName . "' does not appear in row with key " . $key . " but it should\n");
            }

            $actualValue = $data[$key]->$propertyName;

            if ($value != $actualValue) {
                throw new \Exception("Value is equals to '" . $actualValue . "' but it should be equals to " . $value . "\n");
            }
        } else {
            throw new \Exception("Response was not JSON\n" . parent::$response->getBody()->getContents());
        }
    }

    /**
     * @Then /^(?:|the )response has a "([^"]*)" property$/
     *
     * @param $propertyName
     * @throws \Exception
     */
    public function theResponseHasAProperty($propertyName)
    {
        $data = json_decode(parent::$response->getBody(), true);
        if (!empty($data)) {
            if (!$this->isKeyExist($propertyName, $data)) {
                throw new \Exception("Property '" . $propertyName . "' is not set!\n");
            }
        } else {
            throw new \Exception("Response was not JSON\n" . parent::$response->getBody()->getContents());
        }
    }

    /**
     * @Then /^(?:|the )response has a "([^"]*)" property equals to "?(.*?)"?$/
     * @Then /^(?:|the )"([^"]*)" property equals to "([^"]*)"$/
     *
     * @param string $propertyName
     * @param mixed $propertyValue
     * @throws \Exception
     */
    public function theResponseHasAPropertyEquals($propertyName, $propertyValue)
    {
        $data = json_decode(parent::$response->getBody(), true);

        if (empty($data)) {
            throw new \Exception("Response was not array\n" . parent::$response->getBody()->getContents());
        }

        if (!$this->isKeyExist($propertyName, $data)) {
            throw new \Exception("Property '" . $propertyName . "' is not set!\n");
        }

        $currentPropertyValue = $this->findKeyValue($propertyName, $data);

        if (is_array($currentPropertyValue)) {
            $currentPropertyValue = json_encode($currentPropertyValue);
        }

        if ($currentPropertyValue != $propertyValue) {
            throw new \Exception("Property '" . $propertyName . "' equals " . $currentPropertyValue . " but it should equals " . $propertyValue . " \n");
        }

    }

    /**
     * @param $key
     * @param array $array
     *
     * @return bool
     */
    protected function isKeyExist($key, array $array)
    {

        // is in base array?
        if (array_key_exists($key, $array)) {
            return true;
        }

        // check arrays contained in this array
        foreach ($array as $element) {
            if (is_array($element)) {
                if ($this->isKeyExist($key, $element)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param string $key
     * @param array $array
     *
     * @return mixed|null
     */
    protected function findKeyValue($key, array $array)
    {

        // is in base array?
        if (array_key_exists($key, $array)) {
            return $array[$key];
        }

        // check arrays contained in this array
        foreach ($array as $element) {
            if (is_array($element)) {
                $keyValue = $this->findKeyValue($key, $element);

                if (null !== $keyValue) {
                    return $keyValue;
                }
            }
        }

        return null;
    }
}
