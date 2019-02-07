<?php

namespace Drupal\marvel\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * Class MarvelController.
 */
class MarvelController extends ControllerBase {

  /**
   * Returns JSON response for character autocomplete.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The current request object containing the search string.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   A JSON response containing the autocomplete suggestions.
   */
  public function autocomplete(Request $request) {

    $name = $request->query->get('q');

    if (empty($name) || strlen($name) <= 2) {
      return new JsonResponse([]);
    }

    $marvel = \Drupal::service('marvel.marvel_search');
    $matches = $marvel->searchByName($name);

    return new JsonResponse($matches);

  }

  /**
   * Loads search form.
   *
   * @return string
   *   Return Hello string.
   */
  public function search() {
    $search_form = \Drupal::formBuilder()->getForm('Drupal\marvel\Form\SearchForm');

    return [
      $search_form
    ];
  }

  /**
   * Show.
   *
   * @return string
   *   Return Hello string.
   */
  public function show($id) {
    $build = [
      '#theme' => 'marvel_character',
      '#id' => '',
      '#name' => '',
      '#description' => '',
      '#image' => '',
    ];

    $marvel = \Drupal::service('marvel.marvel_search');
    $data = $marvel->findById($id);

    if (!empty($data)) {
      $build['#id'] = $data['id'];
      $build['#name'] = $data['name'];
      $build['#description'] = $data['description'];
      $build['#image'] = $data['image'];
    }

    return $build;
  }

}
