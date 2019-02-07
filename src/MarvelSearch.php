<?php

namespace Drupal\marvel;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Drupal\Component\Datetime\TimeInterface;

/**
 * Class MarvelSearch.
 */
class MarvelSearch implements MarvelSearchInterface {

  /**
   * The Marvel settings.
   *
   * @var \Drupal\Core\Config\Config
   */
  protected $settings;

  /**
   * The HTTP client to fetch the Marvel service endpoint.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected $httpClient;

  /**
   * System time class.
   *
   * @var \Drupal\Component\Datetime\TimeInterface
   */
  protected $time;

  /**
   * Constructs a MarvelSearch object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   * @param \GuzzleHttp\ClientInterface $http_client
   *   A Guzzle client object.
   * @param \Drupal\Component\Datetime\TimeInterface
   *   A System Time object.
   */
  public function __construct(ConfigFactoryInterface $config_factory, ClientInterface $http_client, TimeInterface $time) {
    $this->settings = $config_factory->get('marvel.settings');
    $this->httpClient = $http_client;
    $this->time = $time;
  }

  /**
   * Creates an instance of this class by passing dependencies from the container.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   Service container.
   *
   * @return static
   *   An instance of MarvelSearch.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('http_client'),
      $container->get('datetime.time')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function searchByName($name) {
    $name = trim($name);
    $matches = [];

    if (!$name) {
      return $matches;
    }

    $gateway = trim($this->settings->get('gateway'), '/');
    $url = $gateway . '/characters?nameStartsWith='
      . $name . '&limit=10' . $this->getAuthenticationUrlParameters();;
    $data = $this->fetchData($url);

    if (empty($data) || $data['total'] == 0) {
      return $matches;
    }

    foreach ($data['results'] as $result) {
      $matches[] = [
        'label' => $result['name'],
        'value' => $result['id'],
      ];
    }

    return $matches;
  }

  /**
   * {@inheritdoc}
   */
  public function findById($id) {
    $id = trim($id);
    $info = [];

    if (!$id) {
      return $info;
    }

    $gateway = trim($this->settings->get('gateway'), '/');
    $url = $gateway . '/characters/' . $id . '?'
      . $this->getAuthenticationUrlParameters();
    $data = $this->fetchData($url);

    if (empty($data['results'][0])) {
      return $info;
    }

    $info['id'] = !empty($data['results'][0]['id']) ? $data['results'][0]['id'] : '';
    $info['name'] = !empty($data['results'][0]['name']) ? $data['results'][0]['name'] : '';
    $info['description'] = !empty($data['results'][0]['description']) ? $data['results'][0]['description'] : '';
    $info['thumbnail'] = !empty($data['results'][0]['thumbnail']['path'] && $data['results'][0]['thumbnail']['extension']) ?
      $data['results'][0]['thumbnail']['path'] . '/standard_medium.' . $data['results'][0]['thumbnail']['extension'] : '';
    $info['image'] = !empty($data['results'][0]['thumbnail']['path'] && $data['results'][0]['thumbnail']['extension']) ?
      $data['results'][0]['thumbnail']['path'] . '/standard_amazing.' . $data['results'][0]['thumbnail']['extension'] : '';

    return $info;
  }

  /**
   * Fetch data from Marvel's service endpoint.
   *
   * @param $url
   *
   * @return mixed
   */
  protected function fetchData($url) {
    $data = [];
    $response_body = '';

    // Check if URL is valid.
    if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
      return $data;
    }

    try {
      $response_raw = $this->httpClient
        ->get($url, ['headers' => ['Accept' => '*/*']]);

      $response_body =  $response_raw->getBody()->getContents();
    }
    catch (GuzzleException $exception) {
      watchdog_exception('marvel', $exception);
    }

    $response = json_decode($response_body, TRUE);

    if ($response['code'] == 200) {
      $data = $response['data'];
    }

    return $data;

  }

  /**
   * Provides the necessary query parameters with a leading ampersand.
   *
   * @return string
   * The query parameters for authentication
   */
  public function getAuthenticationUrlParameters() {
    $url_parameters = "";
    $tokens = $this->getAuthenticationTokens();
    foreach ($tokens as $key => $value) {
      $url_parameters .= "&$key=$value";
    }

    return $url_parameters;

  }

  /**
   * Generates authentication parameters.
   *
   * @return array
   * Associative array of authentication parameters.
   */
  protected function getAuthenticationTokens() {
    $timestamp = $this->time->getRequestTime();
    $public_key = $this->settings->get('public_key');
    $private_key = $this->settings->get('private_key');

    return [
      'apikey' => $public_key,
      'ts' => $timestamp,
      'hash' =>  md5($timestamp . $private_key . $public_key)
    ];
  }

}
