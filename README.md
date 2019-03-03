### ![](https://scrutinizer-ci.com/images/logo.png "Scrutinizer") scrutinizer analysis:

[![Build Status](https://scrutinizer-ci.com/g/mikitu/imperial-ingester/badges/build.png?b=master&s=ba3311102bbd5f74404f091eee59e9dfb1475319)](https://scrutinizer-ci.com/g/mikitu/imperial-ingester/build-status/master) [![Code Coverage](https://scrutinizer-ci.com/g/mikitu/imperial-ingester/badges/coverage.png?b=master&s=3ef75967e2b3a22e9cd37ffd02aef3d84e7389db)](https://scrutinizer-ci.com/g/mikitu/imperial-ingester/?branch=master)  [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mikitu/imperial-ingester/badges/quality-score.png?b=master&s=8f29c4e45db52e6b4577e6a6a996f5e049329510)](https://scrutinizer-ci.com/g/mikitu/imperial-ingester/?branch=master) [![Code Intelligence Status](https://scrutinizer-ci.com/g/mikitu/imperial-ingester/badges/code-intelligence.svg?b=master&s=5f0486ccbddeafa234ac592c9d04c6d945b013b5)](https://scrutinizer-ci.com/code-intelligence)
# Imperial Ingester

### Overview
A simple example of consuming an API using PHP

 ### Usage
 #### Prerequisites
  - php v7.2+
  - composer
  - create a config.yaml file and put it in config folder. a config.yaml.dist is already provided and contains necessary values to run the project
  - docker (optional)
 
 ```php
 <?php
 
 require './vendor/autoload.php';
 use App\Service\Api\Consumer;
 use App\Http\Oauth2Client;
 use App\Config\Config;
 use App\Config\YamlParser;
 use App\Service\UniversalTranslator\Translator;
 use App\Service\UniversalTranslator\LanguageProvider\DroidSpeak;
 use GuzzleHttp\Client;
 
 $http_client = new Client();
 $file_parser = new YamlParser();
 $config = new Config('path_to_config', $file_parser);
 $oauth2_client = new Oauth2Client($http_client, $config); 
 $consumer = new Consumer($oauth2_client);
 
 // call https://death.star.api/reactor/exhaust/123 
 $ok = $consumer->deleteExhaust(123);
 
 if (! $ok) {
     echo "cannot destroy. 2 torpedoes are not enough";
 }

 // call https://death.star.api/prison/lea
 $translator = new Translator(new DroidSpeak);
 $response = $consumer->getPrisoner('lea', $translator);
  
 ```
 ### Running tests in a docker container:
 
  `docker build -t imperial-ingester . `
  
  `docker run -d --name imperial-ingester imperial-ingester`
   
  `docker exec -it imperial-ingester /home/project/vendor/bin/phpunit -v --testdox`
  
 ### Running tests with local php:
 
  `composer install`
  
  `./vendor/bin/phpunit -v --testdox`
 
### Test results:
```bash
$ ./vendor/bin/phpunit -v --testdox    
PHPUnit 8.0.4 by Sebastian Bergmann and contributors.

Runtime:       PHP 7.2.15 with Xdebug 2.6.0
Configuration: /Users/mihaibucse/PhpstormProjects/ImperialIngester/phpunit.xml.dist

AppTests\Unit\Config\Config
 ✔ It should create object  15 ms
 ✔ It should throw exception if invalid file path provided  4 ms

AppTests\Unit\Config\YamlParser
 ✔ It should successfully parse yaml  1 ms

AppTests\Unit\Http\Oauth2Client
 ✔ It should create object  44 ms
 ✔ It should return a valid response for post request  9 ms
 ✔ It should throw exception for bad http status  7 ms
 ✔ It should throw exception for bad response  4 ms
 ✔ It should throw exception if missing access token  2 ms
 ✔ It should return a valid response for get request  2 ms
 ✔ It should return a valid response for delete request  4 ms

AppTests\Unit\Service\Api\Consumer
 ✔ It should create object  11 ms
 ✔ It should successfully delete exhaust  5 ms
 ✔ It should not delete exhaust  5 ms
 ✔ It should successfully get prisoner data  8 ms

AppTests\Unit\Service\UniversalTranslator\LanguageProvider\DroidSpeak
 ✔ It should successfully translate text  2 ms
 ✔ It should throw an exception for unknown language  2 ms

AppTests\Unit\Service\UniversalTranslator\Translator
 ✔ It should succesfully execute translate  3 ms

Time: 234 ms, Memory: 6.00 MB

OK (17 tests, 20 assertions)
```