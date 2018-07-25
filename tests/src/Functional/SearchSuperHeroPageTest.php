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
  }

  /**
   * Tests super hero search page.
   */
  public function testSuperHeroSearchPage() {

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

}
