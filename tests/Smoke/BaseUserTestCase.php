<?php

namespace YIPL\Hookah\Test\Smoke;

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
     * @var string
     */
    protected $loginPath = 'user/login';

    /**
     * @var string
     */
    protected $usernameField = 'name';

    /**
     * @var string
     */
    protected $passwordField = 'pass';

    /**
     * @var string
     */
    protected $submitButtonText = 'Log in';

    /**
     * @var array
     */
    protected $users =  [
        ['role'=> 'admin', 'identifier' => 'admin', 'password' => '123admin'],
    ];

    /**
     * @var string
     */
    protected $loggedInLinkText = 'Log out';

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
     *
     * @throws \Exception
     */
    public function __construct($name = null, $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->authenticatedClient = new AuthenticatedClient();
        $this->user                = $this->getUserByRole($this->userRole);
        $this->authenticateClient();
    }

    protected function authenticateClient()
    {
        $crawler = $this->authenticatedClient->request('GET', $this->baseUrl . $this->loginPath);
        $form    = $crawler->selectButton($this->submitButtonText)->form();
        $crawler = $this->authenticatedClient->submit(
            $form,
            [
                $this->usernameField => $this->user['identifier'],
                $this->passwordField => $this->user['password']
            ]
        );
        $this->assertEquals(
            $this->loggedInLinkText,
            $crawler->selectLink($this->loggedInLinkText)->text()
        );
        $this->printLn(
            sprintf('Authenticating with user %s wth role %s was Ok', $this->user['identifier'], $this->user['role'])
        );
    }

    protected function getUserByRole($role)
    {
        foreach ($this->users as $user) {
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
