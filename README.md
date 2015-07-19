# Lom
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ytake/Lom/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/ytake/Lom/?branch=develop)

for php code generator

# feature
##@Data Annotation

```php

use Iono\Lom\Meta\Data;

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

use Iono\Lom\Meta\Data;

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

use Iono\Lom\Meta\NoArgsConstructor;

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

use Iono\Lom\Meta\NoArgsConstructor;

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

use Iono\Lom\Meta\AllArgsConstructor;

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

use Iono\Lom\Meta\AllArgsConstructor;

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
TODO
