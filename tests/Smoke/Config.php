<?php

namespace YIPL\Hookah\Test\Smoke;

/**
 * All configs for the smoke tests
 *
 * Class Config
 * @package Test
 */
class Config
{
    /*
     * @var array
     */
    protected $users;

    /**
     * @var LoginConfig
     */
    protected $loginConfig;

    /**
     * @var string
     */
    protected $loggedInLinkText;

    /**
     * Constructor
     *
     * @param LoginConfig $loginConfig
     * @param array $users
     * @param $loggedInLinkText
     */
    public function __construct(LoginConfig $loginConfig, array $users, $loggedInLinkText)
    {
        $this->loginConfig      = $loginConfig;
        $this->users            = $users;
        $this->loggedInLinkText = $loggedInLinkText;
    }

    /**
     * @return array
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @return string
     */
    public function getLoggedInLinkText()
    {
        return $this->loggedInLinkText;
    }

    /**
     * @return LoginConfig
     */
    public function getLoginConfig()
    {
        return $this->loginConfig;
    }
}
