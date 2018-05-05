# Lom
for php code generator  

[![Build Status](http://img.shields.io/travis/ytake/Lom/master.svg?style=flat-square)](https://travis-ci.org/ytake/Lom)
[![Scrutinizer Code Quality](http://img.shields.io/scrutinizer/g/ytake/Lom.svg?style=flat-square)](https://scrutinizer-ci.com/g/ytake/Lom/)
[![StyleCI](https://styleci.io/repos/38492512/shield?branch=master)](https://styleci.io/repos/38492512)
[![Coverage Status](http://img.shields.io/coveralls/ytake/Lom/master.svg?style=flat-square)](https://coveralls.io/github/ytake/Lom)

# install
```bash
$ composer require ytake/lom --dev  
```

# usage
generate command
```bash
$ vendor/bin/lom generate [scan target dir] 
```

# feature
## @Data Annotation

```php

use Ytake\Lom\Meta\Data;

/**
 * Class DataAnnotation
 * @Data
 */
class DataAnnotation
{

    /**
     * @var string $message
     */
    protected $message;

    /**
     * @var string $testing
     */
    protected $testing;

}

```

after

```php

use Ytake\Lom\Meta\Data;

/**
 * Class DataAnnotation
 * @Data
 */
class DataAnnotation
{

    /**
     * @var string $message
     */
    protected $message;

    public function getMessage()
    {
        return $this->message; 
    }
    
    public function setMessage($message)
    {
        $this->message = $message; 
    }
}
```

## @NoArgsConstructor Annotation

```php

use Ytake\Lom\Meta\NoArgsConstructor;

/**
 * Class DataAnnotation
 * @NoArgsConstructor
 */
class DataAnnotation
{

    public function __construct($message)
    {
        $this->message = $message;
    }
}

```

after 

```php

use Ytake\Lom\Meta\NoArgsConstructor;

/**
 * Class DataAnnotation
 * @NoArgsConstructor
 */
class DataAnnotation
{

}

```

## @AllArgsConstructor Annotation

```php

use Ytake\Lom\Meta\AllArgsConstructor;

/**
 * Class DataAnnotation
 * @AllArgsConstructor
 */
class DataAnnotation
{

    protected $arg1;
    
    protected $arg2;
}

```

after 

```php

use Ytake\Lom\Meta\AllArgsConstructor;

/**
 * Class DataAnnotation
 * @AllArgsConstructor
 */
class DataAnnotation
{

    protected $arg1;
    
    protected $arg2;
    
    public function __construct($arg1, $arg2)
    {
        $this->arg1 = $arg1;
        $this->arg2 = $arg2;
    }
}

```

## @Getter/@Setter Annotation

```php
use Ytake\Lom\Meta\Getter;
use Ytake\Lom\Meta\Setter;

class GetterSetterAnnotation
{
    /**
     * @Getter @Setter
     * @var string $message
     */
    private $message;
    /**
     * @Getter @Setter
     * @var string $testing
     */
    private $testing;
}
```

## @Value Annotation

```php
/**
 * Class ValueAnnotation
 * @\Ytake\Lom\Meta\Value
 */
class ValueAnnotation
{
    /**
     * @var string $message
     */
    protected $message;

    /**
     * @var string $testing
     */
    protected $testing;

    /** @var string $hello */
    protected $hello;
}

```
