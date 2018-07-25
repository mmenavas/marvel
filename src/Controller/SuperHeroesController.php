<?php

namespace Drupal\marvel\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * Class SuperHeroesController.
 */
class SuperHeroesController extends ControllerBase {

  /**
   * Returns JSON response for super hero autocomplete.
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

    $marvel = \Drupal::service('marvel.super_hero_search');
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
    $marvel = \Drupal::service('marvel.super_hero_search');
    $data = $marvel->findById($id);

    return [
      '#theme' => 'marvel_super_hero',
      '#id' => $data['id'],
      '#name' => $data['name'],
      '#description' => $data['description'],
      '#thumbnail' => $data['thumbnail'],
    ];
  }

}
