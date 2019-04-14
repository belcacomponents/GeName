<?php

namespace Belca\GeName\Contracts;

/**
 * Генератор имен.
 *
 * Генерирует любые имена по заданным параметрам, в т.ч. имена файлов.
 * В качестве параметров генерации используется шаблон имени и данные шаблона.
 */
interface NameGenerator
{
    /**
     * Задает шаблон генерации имени.
     *
     * @param string $pattern Шаблон имени
     */
    public function setPattern($pattern);

    /**
     * Возвращает шаблон генерации имени.
     *
     * @return string
     */
    public function getPattern();

    /**
     * Задает параметры шаблона.
     *
     * @param array $params Параметры шаблона
     */
    public function setParams($params = []);

    /**
     * Возвращает параметры шаблона.
     *
     * @return array
     */
    public function getParams();

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
     * Устанавливает классы методов генерации.
     *
     * @param mixed $methods Методы и классы генерации имен
     */
    public function setMethods($methods);

    /**
     * Возвращает список классов методов генерации имен. Если указан конкретный
     * метод, то возвращает его значение.
     *
     * @param  string $method Метод генерации
     * @return mixed
     */
    public function getMethods($method = null);

    /**
     * Возвращает имя класса указанного метода генерации имен.
     *
     * @param  string $method Метод генерации
     * @return string
     */
    public function getMethod($method);

    /**
     * Устанавливает список новых запрещенных символов.
     *
     * @param mixed $symbols Запрещенные символы
     */
    public function setForbiddenSymbols($symbols);

    /**
     * Возвращает список запрещенных символов.
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
     * Устанавливает список генераторов значений параметров шаблона.
     *
     * @param mixed $generators Генераторы значений шаблона
     */
    public function setParamGenerators($generators);

    /**
     * Возвращает список генераторов значений шаблона или указанный генератор.
     *
     * @param  string $generator Имя генератора
     * @return string
     */
    public function getParamGenerators($generator = null);

    /**
     * Добавляет в список генераторов значений шаблона новый класс. Если
     * $replace - true, то заменяет класс с таким же именем параметра.
     *
     * При успешном добавлении возвращает true.
     *
     * @param string  $parameterName  Имя параметра
     * @param string  $generatorClass Имя класса
     * @param boolean $replace        Заменять класс при совпадении имени параметра
     * @return bool
     */
    public function addParamGenerator($parameterName, $generatorClass, $replace = true);

    /**
     * Удаляет генератор значений по названию параметра.
     *
     * При успешном удалении возвращает true.
     *
     * @param  string $parameterName Название параметра или название генератора параметра.
     * @return bool
     */
    public function removeParamGeneratorByParameterName($parameterName);

    /**
     * Удаляет генератор значения параметра по имени класса.
     *
     * При успешном удалении возвращает true.
     *
     * @param  string $className Имя класса-генератора
     * @return bool
     */
    public function removeParamGeneratorByGeneratorClassName($className);

    /**
     * Генерирует имя.
     *
     * @return string
     */
    protected function generate();

    /**
     * Сгенерировать и вернуть одно имя.
     *
     * @return string
     */
    public function generateName();

    /**
     * Сгенерировать и вернуть указанное количество имен.
     *
     * @param  integer $counts Количество генерируемых имен
     * @return array
     */
    public function generateNames($counts);
}
