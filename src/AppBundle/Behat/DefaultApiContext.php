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

use EightPoints\Guzzle\WsseAuthMiddleware;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SetCookie;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\ResponseInterface;
use Sylius\Bundle\ResourceBundle\Behat\DefaultContext;
use Sylius\Component\User\Model\UserInterface;

/**
 * @author Loïc Frémont <loic@mobizel.com>
 */
class DefaultApiContext extends AbstractDefaultContext
{
    /**
     * @var string
     */
    protected static $lastRequestCode;

    /**
     * @var ResponseInterface
     */
    protected static $response;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var array
     */
    protected $parameters = array();

    public function getParameter($name)
    {
        if (count($this->parameters) === 0) {
            throw new \Exception('Parameters not loaded!');
        } else {
            $parameters = $this->parameters;

            return (isset($parameters[$name])) ? $parameters[$name] : null;
        }
    }

    protected function startsWith($haystack, $needle)
    {
        // search backwards starting from haystack length characters from the end
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
    }

    /**
     * @param string $url
     * @param UserInterface|null $user
     * @param string|null $method
     * @param array $data
     * @param null|string $json
     */
    protected function makeRequest($url, UserInterface $user = null, $method = null, $data = array(), $json = null)
    {
        // Reset response
        self::$response = null;

        // Create Request
        $url = $this->locatePath($url);

        if ($user) {
            $wsse = new WsseAuthMiddleware($user->getUsername(), $user->getPassword());
            $stack = HandlerStack::create();

            $this->client = new Client(['handler' => $stack]);
            $stack->push($wsse->attach());
        } else {
            $this->client = new Client([]);
        }

        $body = array();

        // Parse generic form argument
        foreach ($data as $key => $value) {
            if ($this->startsWith($key, 'file')) {
                if (is_null($value)) {
                    continue;
                }

                $path = realpath($this->getContainer()->getParameter('kernel.root_dir') . "/../" . $value);
                $body[$key] = fopen($path, 'r');

            } else if ($this->startsWith($key, 'array_')) {
                if (is_null($value)) {
                    continue;
                }

                $splited = preg_split('/_/', $key);
                $arrayData = preg_split('/,/', $value);

                $body[$splited[1]] = $arrayData;

            } else {
                $body[$key] = $value;
            }
        }

        try {
            // Send request
            if (null === $json and (count($body) !== 0 or $method == 'DELETE' or $method == 'POST' or $method == 'PUT' or $method == 'PATCH')) {
                self::$response = $this->client->request($method, $url, array(
                    'form_params' => $body,
                    'cookies' => $this->getJarDebug(),
                ));
            } elseif (null !== $json) {
                self::$response = $this->client->request($method, $url, array(
                    'body' => $json,
                    'headers' => [
                        "Content-type" => "application/json; charset=utf-8",
                    ],
                    'cookies' => $this->getJarDebug(),
                ));

            } else {
                self::$response = $this->client->request('GET', $url, array(
                    'cookies' => $this->getJarDebug()
                ));
            }

            self::$lastRequestCode = (string)self::$response->getStatusCode();
        } catch (\Exception $e) {
            self::$lastRequestCode = (string)$e->getCode();
        }

    }

    /**
     * @return CookieJar
     */
    private function getJarDebug()
    {
        $jar = new CookieJar();
        $cookie = new SetCookie();
        $cookie->setName('XDEBUG_SESSION');
        $cookie->setValue('XDEBUG_ECLIPSE');
        $jar->setCookie($cookie);

        return $jar;
    }

    /**
     * @param $data
     * @param $propertyName
     * @param $propertyValue
     * @throws \Exception
     */
    protected function checkData($data, $propertyName, $propertyValue)
    {
        $splitData = preg_split('/\./', $propertyName);

        if (count($splitData) == '1') {
            if (!isset($data->$propertyName)) {
                throw new \Exception("Property '" . $propertyName . "' is not set!\n");
            }

            if (trim($data->$propertyName) != trim($propertyValue)) {
                throw new \Exception('Property value mismatch! (given: ' . trim($propertyValue) . ', match: ' . trim($data->$propertyName) . ')');
            }
        } else {
            $next_level = array_shift($splitData);
            $this->checkData($data->$next_level, join('.', $splitData), $propertyValue);
        }
    }
}
