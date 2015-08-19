<?php

namespace Test\Smoke;

/**
 * Class containing the configuration for Logging into the system
 *
 * Class LoginConfig
 * @package Test\Smoke
 */
class LoginConfig
{
    /**
     * @var string
     */
    protected $loginPath;

    /**
     * @var string
     */
    protected $usernameField;

    /**
     * @var string
     */
    protected $passwordField;

    /**
     * @var string
     */
    protected $submitButtonText;

    /**
     * Constructor
     *
     * @param $loginPath
     * @param $usernameField
     * @param $passwordField
     * @param $submitButtonText
     */
    public function __construct($loginPath, $usernameField, $passwordField, $submitButtonText)
    {
        $this->loginPath        = $loginPath;
        $this->usernameField    = $usernameField;
        $this->passwordField    = $passwordField;
        $this->submitButtonText = $submitButtonText;
    }

    /**
     * @return string
     */
    public function getLoginPath()
    {
        return $this->loginPath;
    }

    /**
     * @return string
     */
    public function getUsernameField()
    {
        return $this->usernameField;
    }

    /**
     * @return string
     */
    public function getPasswordField()
    {
        return $this->passwordField;
    }

    /**
     * @return string
     */
    public function getSubmitButtonText()
    {
        return $this->submitButtonText;
    }
}
