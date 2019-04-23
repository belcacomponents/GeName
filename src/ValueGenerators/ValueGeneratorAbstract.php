<?php

namespace Belca\GeName\ValueGenerators;

use Belca\GeName\Contracts\ValueGenerator;

abstract class ValueGeneratorAbstract implements ValueGenerator
{
    /**
     * Аргументы генерации значения без обработки.
     *
     * @var string
     */
    protected $rawArgs = '';

    /**
     * Аргументы генерации значения.
     *
     * @var mixed
     */
    protected $args = [];

    /**
     * Аргументы генерации значения по умолчанию.
     *
     * @var mixed
     */
    protected $defaultArgs = [];

    /**
     * Исходные данные для обработки.
     *
     * @var mixed
     */
    protected $data;

    /**
     * Значение по умолчанию.
     *
     * @var string
     */
    protected $default = '';

    /**
     * Устанавливает специальные данные, которые необходимы для обработки.
     *
     * @param mixed $specialData
     */
    abstract public function __construct($specialData = null);

    /**
     * Устанавливает аргументы функции в сыром виде.
     *
     * @param string $rawArgs
     */
    public function setRawArgs($rawArgs)
    {
        $this->rawArgs = $rawArgs;
    }

    /**
     * Возвращает аргументы функции в сыром виде, если они были заданы.
     *
     * @return string
     */
    public function getRawArgs()
    {
        return $this->rawArgs;
    }

    /**
     * Устанавливает обработанные аргументы функции генерации значения.
     *
     * @param mixed $args
     */
    public function setArgs($args)
    {
        $this->args = $args;
    }

    /**
     * Возвращает аргументы функции генерации значения.
     *
     * @return mixed
     */
    public function getArgs()
    {
        return $this->args;
    }

    /**
     * Вернуть аргументы функции генерации значения по умолчанию.
     *
     * @return mixed
     */
    public function getDefaultArgs()
    {
        return $this->defaultArgs;
    }

    /**
     * Устанавливает исходные данные для обработки.
     *
     * @param mixed $data
     */
    public function setInitialData($data)
    {
        $this->data = $data;
    }

    /**
     * Возвращает исходные данные для обработки.
     *
     * @return mixed
     */
    public function getInitialData()
    {
        return $this->data;
    }

    /**
     * Устанавливает значение ответа генерации по умолчанию.
     *
     * @param string $value
     */
    public function setDefaultValue($value)
    {
        $this->default = $value;
    }

    /**
     * Возвращает значение ответа генерации по умолчанию.
     *
     * @return string
     */
    public function getDefaultValue()
    {
        return $this->default;
    }

    /**
     * Запускает генерацию значения и возвращает сгенерированную строку.
     *
     * @return string
     */
    abstract public function generate();
}
