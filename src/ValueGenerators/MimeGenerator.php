<?php

namespace Belca\GeName\ValueGenerators;

use Belca\GeName\ValueGenerators\ValueGeneratorAbstract;
use Belca\GeName\ValueGenerators\SpecialDataInConstructorTrait;


class MimeGenerator extends ValueGeneratorAbstract
{
    use SpecialDataInConstructorTrait;

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
                $value = $args['value'] ?? $defaultArgs['value'] ?? 'group';

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
