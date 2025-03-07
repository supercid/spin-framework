<!-- MarkdownTOC list_bullets="*" bracket="round" lowercase="true" autolink="true" indent= depth="4" -->

- [1. Cache](#1-cache)
  - [1.1. Instantiating a Cache](#11-instantiating-a-cache)
  - [1.2. Configuring a cache](#12-configuring-a-cache)
  - [1.3. Using multiple cache adapters](#13-using-multiple-cache-adapters)
  - [1.4. Available Cache Adapters](#14-available-cache-adapters)
    - [1.4.1 APCu](#141-apcu)
    - [1.4.2 Redis](#142-redis)
- [2. Examples](#2-examples)
  - [2.1 Setting a value](#21-setting-a-value)
  - [2.2 Getting a value](#22-getting-a-value)
- [3. Writing custom adapters](#3-writing-custom-adapters)

<!-- /MarkdownTOC -->

# 1. Cache
Caching can be used in situations where data retreived from other places does not change often, or is slow to fetch.

Examples are _Static lists_ in databases or entire web-pages that are static.

## 1.1. Instantiating a Cache
The cache in SPIN applications is always available through the ```cache()``` static class.

## 1.2. Configuring a cache
The cache is configured in the ```config-<environment>.json``` file under the `caches` key:

```
  "caches": {
    "apcu": {                                   // Name of Cache
      "adapter": "APCu",                        // Adaptername
      "class": "\\Spin\\Cache\\Adapters\\Apcu", // The class to load
      "options": {}                             // Optional options for class
    }
  }
```

## 1.3. Using multiple cache adapters
Using multiple caches is possible through the naming of the cache.

The config would look like this:

```json
  "caches": {
    "apcu": {                                    // Name of Cache
      "adapter": "APCu",                         // Adaptername
      "class": "\\Spin\\Cache\\Adapters\\Apcu",  // The class to load
      "options": {}                              // Optional options for class
    },
    "redis": {                                   // Name of Cache
      "adapter": "Redis",                        // Adaptername
      "class": "\\Spin\\Cache\\Adapters\\Redis", // The class to load
      "options": {                               // Redis connection options
        "scheme": "tcp",
        "host": "127.0.0.1",
        "port": 6379,
        "connectTimeout": 2.5,
        "auth": ["username", "password"],        // Optional authentication
        "ssl": {"verify_peer": false}            // Optional SSL configuration
      }                              
    }
  }
```

If the code wants to use the "redis" cache then it would be accessed via `cache('redis')`.

## 1.4. Available Cache Adapters

### 1.4.1 APCu
The APCu adapter provides in-memory caching within PHP. It requires the APCu extension to be installed.

### 1.4.2 Redis
The Redis adapter provides distributed caching using Redis. It requires the `predis/predis` package.

Redis connection configuration options:

```php
$connectionDetails = [
    'scheme'          => 'tcp',           // Connection scheme (tcp, unix, etc)
    'host'            => '127.0.0.1',     // Redis server hostname
    'port'            => 6379,            // Redis server port
    'connectTimeout'  => 2.5,             // Connection timeout in seconds
    'auth'            => ['user', 'pass'], // Authentication credentials (optional)
    'ssl'             => ['verify_peer' => false], // SSL options (optional)
];

$cache = new \Spin\Cache\Adapters\Redis($connectionDetails);
```

# 2. Examples

## 2.1 Setting a value
```php
  # Set cache key 'aKey' = 'value' for 10 seconds
  $ok = cache()->set('aKey', 'value', 10);
```

## 2.2 Getting a value
```php
  # Get cache key 'aKey' into $value
  $value = cache()->get('aKey');

```

# 3. Writing custom adapters
_TBD_
