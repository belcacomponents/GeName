<?php

namespace Belca\GeName\ValueGenerators;

use Belca\GeName\ValueGenerators\ValueGeneratorAbstract;
use Belca\GeName\ValueGenerators\SpecialDataInConstructorTrait;
use Belca\GeName\ValueGenerators\ArgsParserTrait;

class MimeGenerator extends ValueGeneratorAbstract
{
    use SpecialDataInConstructorTrait, ArgsParserTrait;

    /**
     * Аргументы генерации значения по умолчанию.
     *
     * @var mixed
     */
    protected $defaultArgs = [
        'value' => 'group',
    ];

    protected $default = 'unknown';

    /**
     * Запускает генерацию значения и возвращает сгенерированную строку.
     *
     * @return string
     */
    public function generate()
    {
        if (isset($this->initialData)) {
            $mime = explode('/', $this->initialData);
            
            if (count($mime) >= 2) {
                $value = $this->args['value'] ?? $this->defaultArgs['value'] ?? 'group';

                if ($value == 'type') {
                    return $mime[1];
                }

                return $mime[0];
            } elseif (count($mime) == 1) {
                return $mime[0];
            }
        }

        return $this->default;
    }
}
