<?php

namespace Drupal\Tests\marvel\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Test character search page
 *
 * @group marvel
 */
class SearchCharacterPageTest extends BrowserTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['marvel'];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    $account = $this->drupalCreateUser([
      'administer marvel settings',
      'access marvel app'
    ]);
    $this->drupalLogin($account);
  }

  public function testLoadCharacterSearchPage() {

    $assert = $this->assertSession();

    // Verify the search form is loaded.
    $this->drupalGet('marvel/search');
    $assert->statusCodeEquals(200);
    $assert->pageTextContains('Find Your Marvel Character');

    $assert->elementExists('css', 'form[action="/marvel/search"]');
    $assert->fieldExists('character_name');
    $assert->buttonExists('Search');
    $assert->hiddenFieldExists('character_id');
  }

  public function testInvalidCharacterId() {

    $assert = $this->assertSession();

    // Verify that page is loaded regardless of invalid id
    $this->drupalGet('marvel/show/invalid-id');
    $assert->statusCodeEquals(200);
    $assert->pageTextContains('No results were found');
  }

}
