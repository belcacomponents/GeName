<?php

namespace Belca\GeName\Contracts;

/**
 * Name generator.
 *
 * Генерирует любые имена по заданным правилам, в т.ч. имена файлов.
 * Для генерации используется шаблон имени, исходные значения, правила
 * генерации, генераторы значений.
 */
interface NameGenerator
{
    /**
     * Sets a name generation pattern.
     *
     * @param  string   $pattern  A name pattern
     * @return boolean
     */
    public function setPattern($pattern);

    /**
     * Returns a name generation pattern.
     *
     * @return string
     */
    public function getPattern();

    /**
     * Sets parameters in the form associated array for name generation.
     *
     * @param array $initialData
     */
    public function setInitialData($initialData);

    /**
     * Returns source data for name generation.
     *
     * @return array
     */
    public function getInitialData();

    /**
     * Возвращает исходные данные для генератора на основе выражения и/или
     * имени генератора.
     *
     * @param  string $expression
     * @param  string $generator
     * @return mixed
     */
    public function getGeneratorInitialData($expression, $generator);

    /**
     * Возвращает исходные данные для генератора по выражению.
     *
     * @param  string $expression
     * @return mixed
     */
    public function getInitialDataByExpression($expression);

    /**
     * Возвращает исходные данные для генератора по названию генератора.
     *
     * @param  string $generator
     * @return mixed
     */
    public function getInitialDataByGenerator($generator);

    /**
     * Задает рабочую директорию.
     *
     * Если задана рабочая директория, то при генерации имени проверяется
     * наличие файла в указанной директории.
     *
     * Если $relative - true, то сгенерированное имя файла проверяется относительно
     * указанного пути. Иначе, выполняется проверка абсолютного имени файла,
     * в которое должен входить путь к файлу.
     *
     * @param string $directory Путь к директории
     * @param bool   $relative  Проверка имени файла относительно указанного пути
     */
    public function setDirectory($directory, $relative = false);

    /**
     * Сбрасывает значение рабочего каталога.
     */
    public function resetDirectory();

    /**
     * Возвращает путь к рабочей директории.
     *
     * @return string
     */
    public function getDirectory();

    /**
     * Устанавливает относительную проверку существования файла.
     *
     * Если $relative - true, то проверка существования имени файла проверяется
     * относительно указанной директории. Если false, то выполняется проверка
     * существования файла, с учетом абсолютного пути имени файла.
     *
     * @param  boolean $relative
     */
    public function relativeFileExists($relative = true);

    /**
     * Устанавливает исключения генерируемых имен.
     *
     * @param array $exceptions Список исключений
     */
    public function setExceptions($exceptions);

    /**
     * Возвращает список исключений.
     *
     * @return array
     */
    public function getExceptions();

    /**
     * Устанавливает классы генерации значений.
     *
     * @param mixed $generators Названия генераторов и классы генерации значений
     */
    public function setGenerators($generators);

    /**
     * Возвращает список генераторов значений. Если указан конкретный
     * генератор, то возвращает его данные.
     *
     * @param  string $generator Название генератора
     * @return mixed
     */
    public function getGenerators($generator = null);

    /**
     * Возвращает имя класса указанного генератора.
     *
     * @param  string $generator Название генератора
     * @return string
     */
    public function getGenerator($generator);

    /**
     * Добавляет в список генераторов значений новый класс. Если
     * $replace - true, то заменяет класс с таким же названием генератора.
     *
     * При успешном добавлении возвращает true.
     *
     * @param string  $generatorName  Имя генератора
     * @param string  $generatorClass Имя класса
     * @param boolean $replace        Заменять класс при совпадении имени генератора
     * @return bool
     */
    public function addGenerator($generatorName, $generatorClass, $replace = true);

    /**
     * Удаляет генератор значений по названию генератора.
     *
     * При успешном удалении возвращает true.
     *
     * @param  string $generatorName
     * @return bool
     */
    public function removeGeneratorByGeneratorName($generatorName);

    /**
     * Удаляет генератор значений по имени класса.
     *
     * При успешном удалении возвращает true.
     *
     * @param  string $className
     * @return bool
     */
    public function removeGeneratorByClassName($className);

    /**
     * Устанавливает список новых запрещенных символов.
     *
     * @param mixed $symbols
     */
    public function setForbiddenSymbols($symbols);

    /**
     * Возвращает список запрещенных символов, если они заданы.
     *
     * @return mixed
     */
    public function getForbiddenSymbols();

    /**
     * Добавляет новый запрещенный символ и его замену.
     *
     * @param string $symbol     Запрещенный символ
     * @param string $substitute Заменяющий символ
     */
    public function addForbiddenSymbol($symbol, $substitute = '', $replace = true);

    /**
     * Удаляет запрещенный символ из списка запрещенных символов.
     *
     * @param  string $symbol Запрещенный символ
     * @return bool
     */
    public function removeForbiddenSymbol($symbol);

    /**
     * Устанавливает список новых разрешенных символов.
     *
     * @param mixed $symbols
     */
    public function setAllowedSymbols($symbols);

    /**
     * Возвращает все разрешенные символы, если они заданы.
     *
     * @return mixed
     */
    public function getAllowedSymbols();

    /**
     * Добавляет новый разрешенный символ.
     *
     * @param string $symbol     Запрещенный символ
     * @param string $substitute Заменяющий символ
     */
    public function addAllowedSymbol($symbol);

    /**
     * Удаляет разрешенный символ из списка разрешенных символов.
     *
     * @param  string $symbol
     * @return bool
     */
    public function removeAllowedSymbol($symbol);

    /**
     * Генерирует и возвращает имя.
     *
     * @return string
     */
    public function generate();

    /**
     * Сгенерировать и вернуть одно имя.
     *
     * @return string
     */
    public function generateName();

    /**
     * Вернуть сгенерированное имя.
     *
     * @return string
     */
    public function getGeneratedName();

    /**
     * Сгенерировать и вернуть указанное количество имен.
     *
     * @param  integer $counts Количество генерируемых имен
     * @return array
     */
    public function generateNames($counts);
}
