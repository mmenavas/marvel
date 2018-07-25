<?php

namespace Drupal\Tests\marvel\Unit;

use Drupal\Tests\UnitTestCase;
use Drupal\marvel\SuperHeroSearch;

/**
 * @coversDefaultClass \Drupal\marvel\SuperHeroSearch
 * @group marvel
 */
class SuperHeroSearchTest extends UnitTestCase {

  /**
   * The tested SuperHeroSearch
   *
   * @var \Drupal\marvel\SuperHeroSearch
   */
  protected $superHeroSearch;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    $config_factory = $this->getConfigFactoryStub(['marvel.settings' => [
      'gateway' => 'http://www.example.com',
      'public_key' => 'abc',
      'private_key' => 'xyz',
    ]]);
    $http_client_mock = $this->createMock('\GuzzleHttp\ClientInterface');
    $time = $this->getMockBuilder('Drupal\Component\Datetime\TimeInterface')->getMock();
    $this->superHeroSearch = new SuperHeroSearch($config_factory, $http_client_mock, $time);
  }

  /**
   * Tests search for super hero by name.
   */
  public function testSearchMethods() {
    // Searching by name with an empty string should return an empty array.
    $empty_string = '';
    $result = $this->superHeroSearch->searchByName($empty_string);
    $this->assertTrue(is_array($result) && count($result) === 0);

    // Looking up by id with an empty string should return an empty array.
    $empty_string = '';
    $result = $this->superHeroSearch->findById($empty_string);
    $this->assertTrue(is_array($result) && count($result) === 0);
  }

  /**
   * Tests authentication URL paramenters
   */
  public function testAuthenticationUrlParamenters() {
    $url_queries = $this->superHeroSearch->getAuthenticationUrlParameters();

    // First character should be an ampersand.
    $this->assertTrue(strpos($url_queries, '&') === 0);

    // timestamp should be present
    $this->assertTrue(strpos($url_queries, 'apikey=') > 0);

    // hash key query should be present.
    $this->assertTrue(strpos($url_queries, 'hash=') > 0);
  }
}
