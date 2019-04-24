<?php

namespace Belca\GeName;

use Belca\GeName\Contracts\NameGenerator;
use Belca\GeName\Contracts\ValueGenerator;
use Belca\GeName\EmbeddedGenerators;

class GeName implements NameGenerator
{
    use EmbeddedGenerators;

    protected $pattern;

    protected $initialData;

    protected $directory;

    protected $exceptions;

    protected $generators;

    protected $generatedName;

    protected $generatedNames;

    /**
     * Генератор по умолчанию.
     *
     * Класс используемый при отсутствии необходимого генератора.
     *
     * @var string
     */
    protected $defaultGenerator = \Belca\GeName\ValueGenerators\DefaultGenerator::class;

    protected $replaceMissingValuesWithGeneratorName = true;

    /**
     * Задает шаблон генерации имени.
     *
     * @param string $pattern Шаблон имени
     * @return boolean
     */
    public function setPattern($pattern)
    {
        if (is_string($pattern)) {
            $this->pattern = $pattern;

            return true;
        }

        return false;
    }

    /**
     * Возвращает шаблон генерации имени.
     *
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * Задает исходные данные для генерации.
     *
     * @param array $initialData
     */
    public function setInitialData($initialData)
    {
        if (is_array($initialData)) {
            $this->initialData = $initialData;
        }
    }

    /**
     * Возвращает все исходные данные для генерации.
     *
     * @return array
     */
    public function getInitialData()
    {
        return $this->initialData;
    }

    /**
     * Возвращает исходные данные для генератора на основе выражения и/или
     * имени генератора.
     *
     * @param  string $expression
     * @param  string $generator
     * @return mixed
     */
    public function getGeneratorInitialData($expression, $generator)
    {
        return $this->initialData[$expression] ?? $this->initialData[$generator] ?? null;
    }

    /**
     * Возвращает исходные данные для генератора по выражению.
     *
     * @param  string $expression
     * @return mixed
     */
    public function getInitialDataByExpression($expression)
    {
        return $this->initialData[$expression] ?? null;
    }

    /**
     * Возвращает исходные данные для генератора по названию генератора.
     *
     * @param  string $generator
     * @return mixed
     */
    public function getInitialDataByGenerator($generator)
    {
        return $this->initialData[$generator] ?? null;
    }

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
    public function setDirectory($directory, $relative = false)
    {
        // TODO должна быть проверка на запись в директорию.
        $this->directory = $directory;
    }

    /**
     * Сбрасывает значение рабочего каталога.
     */
    public function resetDirectory()
    {
        $this->directory = null;
    }

    /**
     * Возвращает путь к рабочей директории.
     *
     * @return string
     */
    public function getDirectory()
    {
        return $this->directory;
    }

    /**
     * Устанавливает относительную проверку существования файла.
     *
     * Если $relative - true, то проверка существования имени файла проверяется
     * относительно указанной директории. Если false, то выполняется проверка
     * существования файла, с учетом абсолютного пути имени файла.
     *
     * @param  boolean $relative
     */
    public function relativeFileExists($relative = true)
    {

    }

    /**
     * Устанавливает исключения генерируемых имен.
     *
     * @param array $exceptions Список исключений
     */
    public function setExceptions($exceptions)
    {
        $this->exceptions = $exceptions;
    }

    /**
     * Возвращает список исключений.
     *
     * @return array
     */
    public function getExceptions()
    {
        return $this->exceptions;
    }

    /**
     * Устанавливает классы генерации значений.
     *
     * @param mixed $generators Названия генераторов и классы генерации значений
     */
    public function setGenerators($generators)
    {
        if (is_array($generators)) {
            $this->generators = $generators;
        }
    }

    /**
     * Возвращает список генераторов значений. Если указан конкретный
     * генератор, то возвращает его данные.
     *
     * @param  string $generator Название генератора
     * @return mixed
     */
    public function getGenerators($name = null)
    {
        return isset($name) && is_string($name)
          ? ($this->generators[$name] ?? null)
          : $this->generators;
    }

    /**
     * Возвращает имя класса указанного генератора.
     *
     * @param  string $generator Название генератора
     * @return string
     */
    public function getGenerator($name)
    {
        return $this->generators[$name] ?? $this->defaultGenerator ?? null;
    }

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
    public function addGenerator($generatorName, $generatorClass, $replace = true)
    {

    }

    /**
     * Удаляет генератор значений по названию генератора.
     *
     * При успешном удалении возвращает true.
     *
     * @param  string $generatorName
     * @return bool
     */
    public function removeGeneratorByGeneratorName($generatorName)
    {

    }

    /**
     * Удаляет генератор значений по имени класса.
     *
     * При успешном удалении возвращает true.
     *
     * @param  string $className
     * @return bool
     */
    public function removeGeneratorByGeneratorClassName($className)
    {

    }

    /**
     * Устанавливает список новых запрещенных символов.
     *
     * @param mixed $symbols Запрещенные символы
     */
    public function setForbiddenSymbols($symbols)
    {
        $this->forbiddenSymbols = $symbols;
    }

    /**
     * Возвращает список запрещенных символов.
     *
     * @return mixed
     */
    public function getForbiddenSymbols()
    {
        return $this->forbiddenSymbols;
    }

    /**
     * Добавляет новый запрещенный символ и его замену.
     *
     * @param string $symbol     Запрещенный символ
     * @param string $substitute Заменяющий символ
     */
    public function addForbiddenSymbol($symbol, $substitute = '', $replace = true)
    {

    }

    /**
     * Удаляет запрещенный символ из списка запрещенных символов.
     *
     * @param  string $symbol Запрещенный символ
     * @return bool
     */
    public function removeForbiddenSymbol($symbol)
    {

    }

    /**
     * Устанавливает список новых разрешенных символов.
     *
     * @param mixed $symbols
     */
    public function setAllowedSymbols($symbols)
    {

    }

    /**
     * Возвращает все разрешенные символы, если они заданы.
     *
     * @return mixed
     */
    public function getAllowedSymbols()
    {

    }

    /**
     * Добавляет новый разрешенный символ.
     *
     * @param string $symbol     Запрещенный символ
     * @param string $substitute Заменяющий символ
     */
    public function addAllowedSymbol($symbol)
    {

    }

    /**
     * Удаляет разрешенный символ из списка разрешенных символов.
     *
     * @param  string $symbol
     * @return bool
     */
    public function removeAllowedSymbol($symbol)
    {

    }

    /**
     * Генерирует имя.
     *
     * @return string
     */
    public function generate()
    {
        $parser = new PatternParser();
        $parser->parse($this->pattern);
        $expressions = $parser->getExpressions();

        $generators = [];
        $generatedValues = [];

        foreach ($expressions as $expression) {

            // Получаем класс генератора по выражению и имени генератора.
            // Если генератора нет, то используем генератор по умолчанию.
            // Если генератора нет, в т.ч. по умолчанию, то либо заменяем значение
            // названием генератора, либо пустотой, либо исходным значением,
            // в зависимости от настроек класса.
            $generatorName = $parser->getGeneratorNameByExpression($expression);
            $generator = $this->getGenerator($generatorName);

            if (isset($generator) && class_exists($generator) && is_subclass_of($generator, ValueGenerator::class)) {
                $initialData = $this->getGeneratorInitialData($expression, $generatorName);
                $generators[$expression] = new $generator($initialData);

                // Аргументы передаем по полному соответствию функции
                $generators[$expression]->setRawArgs($parser->getGeneratorArguments($expression));
                $generatedValues[$expression] = $generators[$expression]->generate();
            }

            // Если выражению не была найдена замена, то заменяем на исходные
            // данные, если были указаны, на название выражения или на пустую,
            // в зависимости от настроек класса.
            if (empty($generatedValues[$expression])) {
                $initialData = $this->getGeneratorInitialData($expression, $generatorName);

                if (! empty($initialData) && is_string($initialData)) {
                    $generatedValues[$expression] = $initialData;
                } elseif (isset($this->replaceMissingValuesWithGeneratorName) && $this->replaceMissingValuesWithGeneratorName) {
                    $generatedValues[$expression] = $generatorName;
                } else {
                    $generatedValues[$expression] = '';
                }
            }
        }

        $name = str_replace($expressions, $generatedValues, $this->pattern);
        //dd($name);

        // Если указана рабочая директория, то проверяем наличие файла
        if (isset($this->directory)) {
            $exists = file_exists($this->directory.'/'.$name); // TODO через while
            // Лучше проверку файла задавать отдельно
            // и проверять через функцию файл сохраненный через generateName
        }

        // если указана проверка на директорию, то проверяем
        // если совпадает, то генерируем значение повторно без новой инициализации классов
        // только заново запускаем и сохраняем значения

        // Также может быть обертка: используется через трейты и использование
        // активации/деактивации и использовать декоратор

        return $name;
    }

    /**
     * Сгенерировать и вернуть одно имя.
     *
     * @return string
     */
    public function generateName()
    {
        $this->generatedName = $this->generate();

        return $this->generatedName;
    }

    public function getGeneratedName()
    {
        return $this->generatedName;
    }

    /**
     * Сгенерировать и вернуть указанное количество имен.
     *
     * @param  integer $counts Количество генерируемых имен
     * @return array
     */
    public function generateNames($counts)
    {

    }

    public function getGeneratedNames()
    {
        return $this->generatedNames;
    }
}
