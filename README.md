# Lom
for php code generator  
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ytake/Lom/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/ytake/Lom/?branch=develop)
[![Build Status](https://travis-ci.org/ytake/Lom.svg?branch=develop)](https://travis-ci.org/ytake/Lom)
[![Coverage Status](https://coveralls.io/repos/ytake/Lom/badge.svg?branch=develop&service=github)](https://coveralls.io/github/ytake/Lom?branch=develop)
[![StyleCI](https://styleci.io/repos/38492512/shield)](https://styleci.io/repos/38492512)  
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/1de254a2-9af5-45cc-aed5-05f6a6cf32cb/mini.png)](https://insight.sensiolabs.com/projects/1de254a2-9af5-45cc-aed5-05f6a6cf32cb)

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
##@Data Annotation

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

##@NoArgsConstructor Annotation

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

##@AllArgsConstructor Annotation

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

##@Getter/@Setter Annotation

##@Value Annotation
