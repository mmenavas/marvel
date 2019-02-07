<?php

namespace Drupal\marvel;

/**
 * Interface MarvelSearchInterface.
 */
interface MarvelSearchInterface {

  /**
   * Provides a list of characters whose name match the supplied keywords.
   *
   * @param string $name
   *   Name keyword.
   *
   * @return array
   *   Associative array containing data about
   */
  public function searchByName($name);

  /**
   * Provides information about a specific character whose id is known.
   *
   * @param string $id
   *   Character id.
   *
   * @return array
   *   Associative array containing character details.
   */
  public function findById($id);

}
