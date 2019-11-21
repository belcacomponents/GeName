<?php

namespace Belca\GeName\ValueGenerators;

use Belca\GeName\ValueGenerators\ValueGeneratorAbstract;
use Belca\GeName\ValueGenerators\DefaultValueInConstructorTrait;

class DefaultGenerator extends ValueGeneratorAbstract
{
    use DefaultValueInConstructorTrait, ArgsParserTrait;

    /**
     * Запускает генерацию значения и возвращает сгенерированную строку.
     *
     * @return string
     */
    public function generate()
    {
        // Если задано значение по умолчанию в аргументах, то возвращаем его
        if (isset($this->args['default']) && is_string($this->args['default'])) {
            return $this->args['default'];
        }

        return (is_string($this->default)) ? $this->default : '';
    }
}
