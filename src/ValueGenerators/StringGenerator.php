<?php

namespace Belca\GeName\ValueGenerators;

use Belca\GeName\ValueGenerators\ValueGeneratorAbstract;
use Belca\GeName\ValueGenerators\DefaultValueInConstructorTrait;
use Belca\GeName\ValueGenerators\ArgsParserTrait;

class StringGenerator extends ValueGeneratorAbstract
{
    use DefaultValueInConstructorTrait, ArgsParserTrait;

    /**
     * Аргументы генерации значения по умолчанию.
     *
     * @var mixed
     */
    protected $defaultArgs = [
        'length' => '25',
    ];

    /**
     * Запускает генерацию значения и возвращает сгенерированную строку.
     *
     * @return string
     */
    public function generate()
    {
        return $this->random($this->args['length'] ?? $this->defaultArgs['length'] ?? 16);
    }

    /**
     * Генерирует произвольную символьно-числовую строку.
     *
     * @param  int  $length
     * @return string
     */
    protected function random($length = 16)
    {
        // From https://laravel.com/api/5.5/Illuminate/Support/Str.html#method_random

        $string = '';

        while (($len = strlen($string)) < $length) {
            $size = $length - $len;
            $bytes = random_bytes($size);
            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }

        return $string;
    }
}
