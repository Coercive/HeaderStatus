Coercive HeaderStatus Utility
=============================

HeaderStatus lets you simply send HTTP response status.

Get
---
```
composer require coercive/headerstatus
```

Usage
-----
```php
use Coercive\Utility\HeaderStatus

# SEND - 200 Defalut Status
HeaderStatus::send();

# SEND - Your Status : Example 301
HeaderStatus::send( 301 );

# SEND - Force don't use php function "http_response_code"
HeaderStatus::send( 418, TRUE );
```
