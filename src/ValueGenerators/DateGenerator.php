<?php

namespace Belca\GeName\ValueGenerators;

use Belca\GeName\ValueGenerators\ValueGeneratorAbstract;
use Belca\GeName\ValueGenerators\DefaultValueInConstructorTrait;

class DateGenerator extends ValueGeneratorAbstract
{
    use DefaultValueInConstructorTrait;

    /**
     * Аргументы генерации значения по умолчанию.
     *
     * @var mixed
     */
    protected $defaultArgs = [
        'format' => 'Y-m-d',
    ];

    /**
     * Запускает генерацию значения и возвращает сгенерированную строку.
     *
     * @return string
     */
    public function generate()
    {
        return date($args['format'] ?? $defaultArgs['format'] ?? "Y-m-d");
    }
}
