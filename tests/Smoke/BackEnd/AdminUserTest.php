<?php

namespace YIPL\Hookah\Test\Smoke\BackEnd;

use YIPL\Hookah\Test\Smoke\BaseUserTestCase;

class AdminUserTest extends BaseUserTestCase
{
    /**
     * @var string
     */
    protected $userRole = 'admin';

    /**
     * Constructor
     *
     * @param null   $name
     * @param array  $data
     * @param string $dataName
     */
    public function __construct($name = null, $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
    }

    /**
     * List all your admin role paths below
     *
     * @return array
     */
    public function providerAdminPaths()
    {
        $adminPaths = [
            ['admin', 200],
            ['admin/config', 200],
            ['not-existing', 404]
        ];

        return $adminPaths;
    }

    /**
     *
     * @throws \Exception
     */
    public function testAdminPageAccessIsOk()
    {
        $this->printSeparator();
        foreach ($this->providerAdminPaths() as $adminPath) {
            $this->printLn(
                sprintf(
                    'Testing path %s to have response code %s for user %s, role %s',
                    $adminPath[0],
                    $adminPath[1],
                    $this->user['identifier'],
                    $this->user['role']
                )
            );
            $this->makeAuthenticatedCall('GET', $adminPath[0], $adminPath[1]);
        }
    }
}
