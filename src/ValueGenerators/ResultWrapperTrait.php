<?php

namespace Belca\GeName\ValueGenerators;

/**
 * Заменяет пробелы указанным значением. По умолчанию "-".
 */
trait ResultWrapperTrait
{
    /**
     * Заменяет пробелы указанным значением в настройках класса.
     *
     * @param mixed $initialData
     */
    public function wrapResult($result)
    {
        return $result; // str_slug
    }
}
