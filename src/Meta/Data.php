<?php
namespace Iono\Lom\Meta;

/**
 * @Annotation
 * @Target("CLASS")
 */
class Data
{

    /**
     * @param \ReflectionClass $class
     */
    public function classReflector(\ReflectionClass $class)
    {
        foreach($class->getProperties() as $property) {
            echo $property->getName();
        }
    }

}
