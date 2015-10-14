# Hookah

Remember the baaje le tanne hookah? We do remember it at [YIPL](http://yipl.com.np).

![Hookah Smoke tests](https://cloud.githubusercontent.com/assets/170554/10163666/811c4604-66c5-11e5-9335-41abc5dd1054.png "Hookah Smoke tests")

Hookah is a small [smoke testing](https://en.wikipedia.org/wiki/Smoke_testing_(software)) command line library for any 
web application. As it is just a sanity check it checks if the given URL returns back the right response code, and body is not empty. 
By the time you listen to this [hookah mero song](https://youtu.be/Ch55A5XyzVE) by Karma band the test would usually finish running. 
Basically it is like the baaje (grandfather) in the above picture testing your application, he does not know to click stuff, 
fill form etc he just says did he see content or a white page. That's smoke testing for you.

If you wish to do other behavior level testing then [Behat](http://behat.org)/[Mink](http://mink.behat.org/en/latest/) or 
[CasperJs](http://casperjs.org/) can be used.

## Build Status

It does not have tests for itself but it will check one of the websites provided in config. For example a Drupal 7 test
installation status is below:

[![Build Status](https://travis-ci.org/younginnovations/hookah.svg?branch=master)](https://travis-ci.org/younginnovations/hookah)

## Prerequisites

You will need PHP installed on your system and have composer running, the package depends on [PHPUnit](https://phpunit.de/)
and [Goutte](https://github.com/FriendsOfPHP/Goutte) 2.x. Goutte depends on [Guzzle](http://guzzle.readthedocs.org/en/latest/).

## Install

Hookah can be cloned after from this github repository and installed following the procedure given below:

* git clone git@github.com:younginnovations/hookah.git
* cd hookah
* composer install --prefer-dist

## Use with other projects

You can use hookah with other projects, it is available on [packagist](http://bit.ly/1LiDppx) and you can get it using 
composer. The following ways:

### With composer require

You can run composer require like the following to get hookah added to your composer.json file:

```
composer require --dev yipl/hookah
```

### Add hookah to your composer.json file

You can even add the following to your `composer.json` in the `require-dev` part:

```
	"yipl/hookah":	"~0.4"
```

## Run

The app can be run with the command below:

* install the application dependencies using command: ` composer install `
* then run `./vendor/bin/phpunit`
 
It should pass like below given you have internet :)

![Hookah Smoke tests passing](https://s3-ap-southeast-1.amazonaws.com/uploads-ap.hipchat.com/140261/1343070/eWyxoBFBy1QvnK1/hookah-passing01.png "Hookah Smoke tests passing")

How fast it runs will depend on your internet speed as it tries to get around 7 URLs from this [test](http://drupal-test.jelastic.elastx.net/) Drupal 7 installation.

## Run tests faster

You can run the tests faster with [paratest](https://github.com/brianium/paratest) with the command below:

```
./vendor/bin/paratest -f --colors -m 2 -p 4 tests 
```

It took like half the time on local machine.

## Docker

Do not have PHP installed in your system? No problems. If you have [docker](https://www.docker.com/) installed run 
the following commands on project root to run Hookah:

* docker pull geshan/php-composer-alpine
* docker run -v $(pwd):/var/www geshan/php-composer-alpine "composer install --prefer-dist"
* docker run -v $(pwd):/var/www geshan/php-composer-alpine "./vendor/bin/phpunit --version"
* docker run -v $(pwd):/var/www geshan/php-composer-alpine "./vendor/bin/phpunit"

The first command will pull the container from docker hub registry, it is only`~40 MB` of data. 
The second command will install all the composer dependencies from the container.

The third command is optional, it will just print the phpunit version. The fourth command will run the tests from within 
the docker container.

## Structure

The application is structured in a very simple way in `tests\Smoke` folder.

Smoke folder contains other 2 folders
- FrontEnd: to test response codes of front end user visible part of the website/web application without logging in. 
- BackEnd: to test areas of the website/web application accessible after logging in.

The structure can be changed as this application now is a proof of concept to smoke test inspired by 
[this](http://bit.ly/1IUtepX) blog post (the code has been written differently following PSR-2 and newer libraries, 
still the essence is same).

## Settings

You can set the base URL at `BaseTestCase.php` and users of the application at `BaseUserTestCase.php` constructor method. like

```
/**
 * @var string
 */
protected $baseUrl = 'http://drupal-test.jelastic.elastx.net/';

//other variables to override

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

```

You can add your frontend paths in `providerFrontEnd` method in the PagesTest.Case extended from BaseTestCase.php file like below:

```
     return [
                [$this->baseUrl, 200],
                ['about', 200],
                ['not-existing', 404],
                ['.git', 403],
            ];

```

It uses php unit [data providers](https://phpunit.de/manual/current/en/writing-tests-for-phpunit.html#writing-tests-for-phpunit.data-providers.examples.DataTest.php) 
to take each of them to run the test case for front end tests. 

The backend part is there too. The settings can be found in    `AdminUserTest` extending `BaseUserTestCase` class, `providerBackEndPaths` method like below:

```
    $adminPaths = [
        ['admin', 200],
        ['admin/config', 200],
        ['not-existing', 404]
    ];

```

The tests are for now done for `http://drupal-test.jelastic.elastx.net/` for proof of concept, it is advised to hit the staging servers for 
smoke test than live servers depending on the need.

## Coding Conventions

We follow PSR-2 even to write tests.

## Integration with travis

It can be integrated with travis CI to run the test on each push check the `.travis.yml` file in root of this project. 
It can be integrated in the same way with other CI systems too.

## Contribute

We would like to hear from you.
