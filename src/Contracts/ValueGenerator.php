<?php

namespace Belca\GeName\Contracts;

/**
 * Генератор значения.
 *
 * Предназначен для реализации генерации конкретного значения.
 */
interface ValueGenerator
{
    /**
     * Устанавливает специальные данные для генерации значения.
     *
     * @param mixed $specialData
     */
    public function __construct($specialData = null);

    /**
     * Устанавливает аргументы функции в сыром виде.
     *
     * @param string $rawArgs
     */
    public function setRawArgs($rawArgs);

    /**
     * Возвращает аргументы функции в сыром виде, если они были заданы.
     *
     * @return string
     */
    public function getRawArgs();

    /**
     * Устанавливает обработанные аргументы функции генерации значения.
     *
     * @param mixed $args
     */
    public function setArgs($args);

    /**
     * Возвращает аргументы функции генерации значения.
     *
     * @return mixed
     */
    public function getArgs();

    /**
     * Вернуть аргументы функции генерации значения по умолчанию.
     *
     * @return mixed
     */
    public function getDefaultArgs();

    /**
     * Устанавливает исходные данные для обработки.
     *
     * @param mixed $data
     */
    public function setInitialData($data);

    /**
     * Возвращает исходные данные для обработки.
     *
     * @return mixed
     */
    public function getInitialData();

    /**
     * Устанавливает значение ответа генерации по умолчанию.
     *
     * @param string $value
     */
    public function setDefaultValue($value);

    /**
     * Возвращает значение ответа генерации по умолчанию.
     *
     * @return string
     */
    public function getDefaultValue();

    /**
     * Запускает генерацию значения и возвращает сгенерированную строку.
     *
     * @return string
     */
    public function generate();
}
