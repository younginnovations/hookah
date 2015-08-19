<?php

namespace Test\Smoke;

use Goutte\Client as AuthenticatedClient;

class BaseUserTestCase extends BaseTestCase
{
    /**
     * @var AuthenticatedClient
     */
    protected $authenticatedClient;

    /**
     * @var array
     */
    protected $user = [];

    /**
     * @var Config
     */
    protected $config;

    /**
     * To be overridden by child class
     *
     * @var string
     */
    protected  $userRole = 'none';

    /**
     * Constructor
     *
     * @param null $name
     * @param array $data
     * @param string $dataName
     * @throws \Exception
     */
    public function __construct($name = null, $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->config = new Config(
            new LoginConfig('user/login', 'name', 'pass', 'Log in'),
            [
                ['role'=> 'admin', 'identifier' => 'admin', 'password' => '123admin'],
            ],
            'Log out'
        );

        $this->authenticatedClient = new AuthenticatedClient();
        $this->user                = $this->getUserByRole($this->userRole);
        $this->authenticateClient();
    }

    protected function authenticateClient()
    {
        $loginConfig = $this->config->getLoginConfig();
        $crawler     = $this->authenticatedClient->request('GET', $this->baseUrl . $loginConfig->getLoginPath());
        $form    = $crawler->selectButton($loginConfig->getSubmitButtonText())->form();
        $crawler = $this->authenticatedClient->submit(
            $form,
            [
                $loginConfig->getUsernameField() => $this->user['identifier'],
                $loginConfig->getPasswordField() => $this->user['password']
            ]
        );
        $this->assertEquals(
            $this->config->getLoggedInLinkText(),
            $crawler->selectLink($this->config->getLoggedInLinkText())->text()
        );
        $this->printLn(
            sprintf('Authenticating with user %s wth role %s was Ok', $this->user['identifier'], $this->user['role'])
        );
    }

    protected function getUserByRole($role)
    {
        foreach ($this->config->getUsers() as $user) {
            if ($user['role'] === $role) {
                return $user;
            }
        }

        throw new \Exception(sprintf('User with role %s not found', $role));
    }

    protected function makeAuthenticatedCall($method = 'GET', $path, $responseCode)
    {
        $crawler = $this->authenticatedClient->request($method, $this->baseUrl . $path);
        $this->assertEquals(
             $responseCode,
             $this->authenticatedClient->getResponse()->getStatus(),
             sprintf('Test for path %s', $path)
        );
        $this->assertNotNull($crawler->filter('body')->text());
    }
}
