<?php



namespace App\Tests\Behat\Service;

interface SharedStorageInterface
{
    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get($key);

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has($key);

    /**
     * @param string $key
     * @param mixed  $resource
     */
    public function set($key, $resource);

    /**
     * @return mixed
     */
    public function getLatestResource();

    /**
     * @param array $clipboard
     *
     * @throws \RuntimeException
     */
    public function setClipboard(array $clipboard);
}
