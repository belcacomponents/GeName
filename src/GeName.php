<?php

namespace Belca\GeName;

use Belca\GeName\Contracts\NameGenerator;
use Belca\GeName\Contracts\ValueGenerator;
use Belca\GeName\EmbeddedGenerators;

class GeName implements NameGenerator
{
    use EmbeddedGenerators;

    /**
     * Шаблон генерации имени.
     *
     * @var string
     */
    protected $pattern;

    /**
     * Исходные данные для генерации имени.
     *
     * @var mixed
     */
    protected $initialData;

    /**
     * Путь к рабочей директории.
     *
     * @var string|null
     */
    protected $directory;

    /**
     * Список исключенных имен.
     *
     * Если указаны имена файлов, то имена должны быть указаны относительно
     * заданной директории.
     *
     * @var array
     */
    protected $exceptions;

    // WARNING: Можно использовать либо $allowedSybomls, $forbiddenSymbols,
    // но не вместе.
    // Приоритетом считаются запрещенные символы.
    // Реализация запрещенных символов осуществляется в обработчиках, т.о.
    // указание запрещенных символов может не оказать никакого эффекта.

    /**
     * Разрешенные символы.
     *
     * Пустой массив или null считаются, что все символы разрешены.
     *
     * @var array
     */
    protected $allowedSybomls;

    /**
     * Запрещенные символы.
     *
     * Содержит список запрещенных символов, и заменяющие значения, если
     * запрещенные символы необходимо заменять.
     *
     * @var mixed
     */
    protected $forbiddenSymbols;

    /**
     * Список генераторов: ключ - код генератора, значение - класс генератора.
     *
     * @var array
     */
    protected $generators;

    /**
     * Сгенерированное имя.
     *
     * @var array
     */
    protected $generatedName;

    /**
     * Список сгенерированных имен.
     *
     * @var array
     */
    protected $generatedNames;

    /**
     * Сгенерированные значения для одного имени.
     *
     * @var array
     */
    protected $generatedValues;

    /**
     * Сгенерированные значения для списка имен.
     *
     * @var array
     */
    protected $generatedValuesNames;

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
     * @return string|null
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
     * Пример.
     *
     *
     * #1. Путь относительно корневой директории:
     *
     * $directory = '', $filename = '/usr/var/www/app/files/gename.txt'
     *
     * В таком случае можно осуществлять относительную проверку. Также путь
     * к файлам может быть абсолютно любым, например, '/home/user/files/'.
     *
     *
     * #2. Путь относительно директории с файлами:
     *
     * $directory = '/usr/var/www/app/files/', $filename = 'gename.txt'
     *
     * В таком случае осуществляется относительная проверка файла и проверка
     * всех генерируемых имен будет осуществляться относительно указанной
     * директории.
     *
     *
     * #3. Абсолютный путь к файлу:
     *
     * $directory = null, $filename = '/usr/var/www/app/files/gename.txt'
     *
     * В таком случае может осуществляться только абсолютная проверка файла,
     * а путь к файлу или шаблон генерации имени файла должен быть с абсолютным
     * путем к файлу.
     * Также, допускается такой вариант использования, если не используется
     * проверка существования файла с указанным имененем.
     *
     * @param  boolean $relative
     */
    public function relativeFileExists($relative = true)
    {
        $this->relative = $relative;
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
     * Возвращает список исключений - запрещенные имена для генерации.
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
        // TODO добавляет класс обработчика в список обработчиков,
        // при этом выполняется проверка интерфейса генератора
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
        // TODO удаляет класс при успешном удалении возвращает true
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
        // TODO осуществляет список всех классов с указанным имененм и возвращает
        // количество удаленных обработчиков
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
        // TODO список запрещенных символов
    }

    /**
     * Удаляет запрещенный символ из списка запрещенных символов.
     *
     * @param  string $symbol Запрещенный символ
     * @return bool
     */
    public function removeForbiddenSymbol($symbol)
    {
        // TODO список запрещенных символов
    }

    /**
     * Устанавливает список новых разрешенных символов.
     *
     * @param mixed $symbols
     */
    public function setAllowedSymbols($symbols)
    {
        // TODO список запрещенных символов
    }

    /**
     * Возвращает все разрешенные символы, если они заданы.
     *
     * @return mixed
     */
    public function getAllowedSymbols()
    {
        return $this->allowedSybomls;
    }

    /**
     * Добавляет новый разрешенный символ.
     *
     * @param string $symbol     Запрещенный символ
     * @param string $substitute Заменяющий символ
     */
    public function addAllowedSymbol($symbol)
    {
        // TODO разрешенный символ
    }

    /**
     * Удаляет разрешенный символ из списка разрешенных символов.
     *
     * @param  string $symbol
     * @return bool
     */
    public function removeAllowedSymbol($symbol)
    {
        // TODO удаляет символ
    }

    /**
     * Генерирует имя и возвращает сгенерированое имя.
     *
     * @param  integer $attempts               Количество попыток генерации имени
     * @param  array   $exceptions             Список исключенных имен
     * @param  boolean $returnGeneratedValues  Возвращать массив "[имя, сгенерированные значения]"
     * @return string|boolean|mixed
     */
    public function generate($attempts = 10, $exceptions = [], $returnGeneratedValues = false)
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

                // TODO в генератор нужно передать разрешенные и запрещенные символы,
                // и он сам должен решить, нужно ли их обрабатывать или нет.
                // Также туда передаются исключенные имена

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

        // TODO Проверять на исключенные имена
        // $exceptions

        // Если указана рабочая директория, то проверяем наличие файла,
        // иначе проверка файла отключена.
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

        return $returnGeneratedValues ? [$name, $generatedValues] : $name;
    }

    /**
     * Генерирует, сохраняет в текущем экземпляре класса и возвращает одно имя.
     *
     * Если $exceptions = null, то будут использованы значения исключений
     * глобальных переменных.
     *
     * @param  integer $attempts   Количество попыток генерации имени
     * @param  array   $exceptions Список исключенных имен
     * @return string
     */
    public function generateName($attempts = 10, $exceptions = null)
    {
        list($this->generatedName, $this->generatedValues) = $this->generate($attempts, $exceptions ?? $this->exceptions, true);

        return $this->generatedName;
    }

    /**
     * Возвращает сгенерированное имя, если оно было сгенерировано функцией
     * generateName().
     *
     * @return string
     */
    public function getGeneratedName()
    {
        return $this->generatedName;
    }

    /**
     * Возвращает сгенерированные значения к одному имени, если они были
     * сгенерированы функцией generateName().
     *
     * @return array
     */
    public function getGeneratedValues()
    {
        return $this->generatedValues;
    }

    /**
     * Генерирует и возвращает указанное количество имен.
     *
     * @param  integer $counts     Количество генерируемых имен
     * @param  boolean $duplicates Если true, то разрешены дубликаты имен
     * @param  integer $attempts   Число попыток генерации одного имени
     * @param  array   $exceptions Исключенные имена
     * @return array
     */
    public function generateNames($counts, $duplicates = false, $attempts = 10, $exceptions = null)
    {
        $this->generatedNames = [];
        $this->generatedValuesNames = [];

        if (is_integer($counts) && $counts > 0) {

            for ($i = 0; $i < $counts; $i++) { // TODO должен быть while и ограниченное число попыток генерации имени
                list($name, $values) = $this->generate($attempts, $expressions, true);

                // Если дубликаты запрещены, то проверяем наличие имени в текущем списке
                if (! $duplicates) {
                    // TODO выполняем поиск значений в текущем списке значений
                    if (in_array($this->generatedNames, $name)) {
                        // Сбрасываем итерацию и повторно генерируем имя
                    }
                }

                $this->generatedNames[$i] = $name;
                $this->generatedValuesNames[$i] = $values;
            }
        }

        return $this->generatedName;
    }

    /**
     * Возвращает сгенерированные имена.
     *
     * @return array
     */
    public function getGeneratedNames()
    {
        return $this->generatedNames;
    }

    /**
     * Возвращает сгенерированые значения списка имен.
     *
     * @return array
     */
    public function getGeneratedValuesNames()
    {
        return $this->generatedValuesNames;
    }
}
