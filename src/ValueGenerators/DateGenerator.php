<?php

namespace Belca\GeName\ValueGenerators;

use Belca\GeName\ValueGenerators\ValueGeneratorAbstract;
use Belca\GeName\ValueGenerators\DefaultValueInConstructorTrait;
use Belca\GeName\ValueGenerators\ArgsParserTrait;

class DateGenerator extends ValueGeneratorAbstract
{
    use DefaultValueInConstructorTrait, ArgsParserTrait;

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
        return date($this->args['format'] ?? $this->defaultArgs['format'] ?? "Y-m-d");
    }
}
