Noiselabs ZfDebugModule
=======================

[![Join the chat at https://gitter.im/noiselabs/zf-debug-utils](https://badges.gitter.im/noiselabs/zf-debug-utils.svg)](https://gitter.im/noiselabs/zf-debug-utils?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![Build Status](https://travis-ci.org/noiselabs/zf-debug-utils.svg?branch=master)](https://travis-ci.org/noiselabs/zf-debug-utils)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/noiselabs/zf-debug-utils/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/noiselabs/zf-debug-utils/?branch=master)

Console commands and other utilities for debugging ZF2 apps.

Installation
------------

Install the package via Composer:

```bash
composer require noiselabs/zf-debug-utils
```
    
    
Then enable this module by adding it and `AssetManager` (a dependency) to `application.config.php`.
    
```php
<?php
'modules' => [
    'AssetManager',
    'Noiselabs\ZfDebugModule',
],
```

License
-------

This library is licensed under the MIT License. See the [LICENSE file](https://github.com/noiselabs/zf-debug-utils/blob/master/LICENSE) for details.

Authors
-------

Vítor Brandão - <vitor@noiselabs.io> ~ [twitter.com/noiselabs](http://twitter.com/noiselabs) ~ [https://noiselabs.io](https://noiselabs.io)

See also the list of [contributors](https://github.com/noiselabs/zf-debug-utils/contributors) who participated in this project.


Submitting bugs and feature requests
------------------------------------

Bugs and feature requests are tracked on [GitHub](https://github.com/noiselabs/zf-debug-utils/issues).