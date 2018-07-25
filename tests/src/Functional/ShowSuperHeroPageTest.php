<?php

namespace Drupal\Tests\marvel\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Test show super hero page
 *
 * @group marvel
 */
class ShowSuperHeroPageTest extends BrowserTestBase {

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
  public function testSuperHeroShowPage() {

    $assert = $this->assertSession();

    // Verify that page is loaded regardless of invalid id
    $this->drupalGet('marvel/show/id');
    $assert->statusCodeEquals(200);
    $assert->pageTextContains('No results were found');
  }

}
