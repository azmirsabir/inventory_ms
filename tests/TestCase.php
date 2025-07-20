<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use function PHPUnit\Framework\assertEquals;

abstract class TestCase extends BaseTestCase
{
  public function test_homepage_returns_ok()
  {
    $response = $this->get('/');
    
    $response->assertStatus(200);
  }
}
