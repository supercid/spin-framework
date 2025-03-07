<?php declare(strict_types=1);

namespace Spin\tests\Core;

use PHPUnit\Framework\TestCase;
use \Spin\Cache\Adapters\Redis;

class RedisTest extends TestCase
{
  protected $cacheObj;

  public function setup(): void
  {
    // Skip tests if Redis is not available
    if (!class_exists('Predis\Client')) {
      $this->markTestSkipped('Predis client is not available');
    }

    $connectionDetails = [
      'scheme' => 'tcp',
      'host' => getenv('REDIS_HOST') ?: '127.0.0.1',
      'port' => getenv('REDIS_PORT') ?: 6379,
    ];

    // Add auth if credentials are provided
    if (getenv('REDIS_PASSWORD')) {
      $connectionDetails['auth'] = [getenv('REDIS_USERNAME') ?: 'default', getenv('REDIS_PASSWORD')];
    }

    $this->cacheObj = new Redis($connectionDetails);
  }

  public function testRedisAdapterCreated()
  {
    $this->assertNotNull($this->cacheObj);
  }

  public function testSetAndGet()
  {
    $key = 'test_key';
    $value = 'test_value';
    
    $result = $this->cacheObj->set($key, $value);
    $this->assertTrue($result);
    
    $retrievedValue = $this->cacheObj->get($key);
    $this->assertEquals($value, $retrievedValue);
  }

  public function testHas()
  {
    $key = 'test_has_key';
    $value = 'test_has_value';
    
    $this->cacheObj->set($key, $value);
    $this->assertTrue($this->cacheObj->has($key));
    
    $this->cacheObj->delete($key);
    $this->assertFalse($this->cacheObj->has($key));
  }

  public function testDelete()
  {
    $key = 'test_delete_key';
    $value = 'test_delete_value';
    
    $this->cacheObj->set($key, $value);
    $this->assertTrue($this->cacheObj->has($key));
    
    $result = $this->cacheObj->delete($key);
    $this->assertTrue($result);
    $this->assertFalse($this->cacheObj->has($key));
  }

  public function testIncrement()
  {
    $key = 'test_increment_key';
    
    $this->cacheObj->set($key, 1);
    $result = $this->cacheObj->inc($key, 1);
    
    $this->assertEquals(2, $result);
    $this->assertEquals(2, $this->cacheObj->get($key));
  }
}