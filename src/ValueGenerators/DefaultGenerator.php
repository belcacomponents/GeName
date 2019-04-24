<?php

namespace Belca\GeName\ValueGenerators;

use Belca\GeName\ValueGenerators\ValueGeneratorAbstract;
use Belca\GeName\ValueGenerators\DefaultValueInConstructorTrait;

class DefaultGenerator extends ValueGeneratorAbstract
{
    use DefaultValueInConstructorTrait;

    /**
     * Запускает генерацию значения и возвращает сгенерированную строку.
     *
     * @return string
     */
    public function generate()
    {
        return (is_string($this->default)) ? $this->default : '';
    }
}
