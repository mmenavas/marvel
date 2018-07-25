<?php

namespace Drupal\marvel;

/**
 * Interface SuperHeroSearchInterface.
 */
interface SuperHeroSearchInterface {

  /**
   * Provides a list of super heros whose name match the supplied keywords.
   *
   * @param string $name
   *   Name keyword.
   *
   * @return array
   *   Associative array containing data about
   */
  public function searchByName($name);

  /**
   * Provides information about a specific super hero whose id is known.
   *
   * @param string $id
   *   Super hero id.
   *
   * @return array
   *   Associative array containing super hero details.
   */
  public function findById($id);

}
