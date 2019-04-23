<?php

namespace Belca\GeName\ValueGenerators;

/**
 * Конструктор задает значение по умолчанию.
 */
trait DefaultValueInConstructorTrait
{
    /**
     * Устанавливает значение по умолчанию, в случае невозможности генерации
     * значения.
     *
     * @param string $default
     */
    public function __construct($default = null)
    {
        $this->default = $default;
    }
}
