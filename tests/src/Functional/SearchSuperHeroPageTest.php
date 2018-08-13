<?php

namespace Drupal\Tests\marvel\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Test super hero search page
 *
 * @group marvel
 */
class SearchSuperHeroPageTest extends BrowserTestBase {

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

  public function testLoadSuperHeroSearchPage() {

    $assert = $this->assertSession();

    // Verify the search form is loaded.
    $this->drupalGet('marvel/search');
    $assert->statusCodeEquals(200);
    $assert->pageTextContains('Find Your Marvel Super Hero');

    $assert->elementExists('css', 'form[action="/marvel/search"]');
    $assert->fieldExists('super_hero_name');
    $assert->buttonExists('Search');
    $assert->hiddenFieldExists('super_hero_id');
  }

  public function testInvalidSuperHeroId() {

    $assert = $this->assertSession();

    // Verify that page is loaded regardless of invalid id
    $this->drupalGet('marvel/show/invalid-id');
    $assert->statusCodeEquals(200);
    $assert->pageTextContains('No results were found');
  }

  public function testRealSuperHeroId() {

    $assert = $this->assertSession();

    $this->drupalGet('marvel/show/1009718');
    $assert->statusCodeEquals(200);
    $assert->pageTextContains('Wolverine');
  }
}
