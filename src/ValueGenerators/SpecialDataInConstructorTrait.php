<?php

namespace Belca\GeName\ValueGenerators;

/**
 * Конструктор задает исходные данные для генерации значения.
 */
trait SpecialDataInConstructorTrait
{
    /**
     * Устанавливает исходные данные необходимые для генерации значения.
     *
     * @param mixed $initialData
     */
    public function __construct($initialData = null)
    {
        $this->initialData = $initialData;
    }
}
