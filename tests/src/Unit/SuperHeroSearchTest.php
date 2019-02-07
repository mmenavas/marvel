<?php

namespace Drupal\Tests\marvel\Unit;

use Drupal\Tests\UnitTestCase;
use Drupal\marvel\MarvelSearch;

/**
 * @coversDefaultClass \Drupal\marvel\MarvelSearch
 * @group marvel
 */
class CharacterSearchTest extends UnitTestCase {

  /**
   * The tested CharacterSearch
   *
   * @var \Drupal\marvel\MarvelSearch
   */
  protected $characterSearch;

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
    $this->characterSearch = new MarvelSearch($config_factory, $http_client_mock, $time);
  }

  /**
   * Tests search for character by name.
   */
  public function testSearchMethods() {
    // Searching by name with an empty string should return an empty array.
    $empty_string = '';
    $result = $this->characterSearch->searchByName($empty_string);
    $this->assertTrue(is_array($result) && count($result) === 0);

    // Looking up by id with an empty string should return an empty array.
    $empty_string = '';
    $result = $this->characterSearch->findById($empty_string);
    $this->assertTrue(is_array($result) && count($result) === 0);
  }

  /**
   * Tests authentication URL paramenters
   */
  public function testAuthenticationUrlParamenters() {
    $url_queries = $this->characterSearch->getAuthenticationUrlParameters();

    // First character should be an ampersand.
    $this->assertTrue(strpos($url_queries, '&') === 0);

    // apikey should be present
    $this->assertTrue(strpos($url_queries, 'apikey=') > 0);

    // hash key query should be present.
    $this->assertTrue(strpos($url_queries, 'hash=') > 0);
  }
}
