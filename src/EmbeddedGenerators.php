<?php

namespace Belca\GeName;

/**
 * Генераторы значений поставляемые вместе с пакетом.
 */
trait EmbeddedGenerators
{
    /**
     * Встроенные генераторы.
     *
     * @var array
     */
    protected $embeddedGenerators = [
        'date' => \Belca\GeName\ValueGenerators\DateGenerator::class,
        'mime' => \Belca\GeName\ValueGenerators\MimeGenerator::class,
        'string' => \Belca\GeName\ValueGenerators\StringGenerator::class,
    ];

    public function __construct()
    {
        $this->setGenerators($this->embeddedGenerators);
    }
}
