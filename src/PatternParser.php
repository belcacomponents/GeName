<?php

namespace Belca\GeName;

/**
 * Парсер шаблона.
 */
class PatternParser
{
    protected $regex; // = "/(\{([[:alnum:]-_]+)(<([[:alnum:]-_=:'\";]*)>)?\})/";

    protected $methodNamePattern = [
        'prefix' => '[[:alnum:]',
        'suffix' => ']+',
    ];

    protected $paramsPattern = [
        'prefix' => '[[:alnum:]',
        'suffix' => ']*'
    ];

    protected $allowedCharactersMethodName = '-_';

    protected $allowedCharactersPatternParams = '-_=:\'";';

    protected $variableWrapperCharacters = [
        'prefix' => '\{',
        'suffix' => '\}',
    ];

    protected $parameterWrapperCharacters = [
        'prefix' => '<',
        'suffix' => '>',
    ];

    /**
     * Массив необработанных значений парсинга шаблона.
     *
     * @var mixed
     */
    protected $rawMatches;

    /**
     * Массив выражений шаблона, где в качестве ключа - искомое выражение,
     * в качестве значений - название генератора и аргументы функции.
     *
     * @var mixed
     */
    protected $matches;

    /**
     * Используемые генераторы и/или строковые выражения.
     *
     * @var array
     */
    protected $generators;

    function __construct()
    {
        $this->buildRegex();
    }

    public function buildRegex()
    {
        $this->regex = "/(";
        $this->regex .= $this->variableWrapperCharacters['prefix'] ?? '\{';

        $this->regex .= "(";

        $this->regex .= $this->methodNamePattern['prefix'] ?? '[[:alnum:]';
        $this->regex .= $this->allowedCharactersMethodName ?? '-_';
        $this->regex .= $this->methodNamePattern['suffix'] ?? ']+';

        $this->regex .= ")";

        $this->regex .= '(';
        $this->regex .= $this->parameterWrapperCharacters['prefix'] ?? '<';

        $this->regex .= "(";

        $this->regex .= $this->paramsPattern['prefix'] ?? '[[:alnum:]';
        $this->regex .= $this->allowedCharactersPatternParams ?? '-_=:\'";';
        $this->regex .= $this->paramsPattern['suffix'] ?? ']*';

        $this->regex .= ")";

        $this->regex .= $this->parameterWrapperCharacters['suffix'] ?? '>';
        $this->regex .= ')?';

        $this->regex .= $this->variableWrapperCharacters['suffix'] ?? '\}';
        $this->regex .= ")/";
    }

    /**
     * Возвращает строку регулярного выражения.
     *
     * @return string
     */
    public function getRegex()
    {
        return $this->regex;
    }

    /**
     * Разбирает указанную строку в соответствии с регулярным выражением.
     *
     * @param  string $string
     * @return mixed
     */
    public function parse($string)
    {
        preg_match_all($this->regex, $string, $matches);

        $this->rawMatches = $matches;

        $this->matches = $this->normalize($matches);

        $this->relations = $this->defineRelationships($this->matches);

        return $matches;
    }

    /**
     * Приводит результат поиска совпадений в нормальный вид: в качестве ключа
     * исходное  совпадение, в качестве значения название метода генерации и
     * аргументы функции.
     *
     * @param  mixed $array
     * @return mixed
     */
    protected function normalize($array)
    {
        $matches = [];

        if (! empty($array) && count($array)) {
            $amountMatches = count($array[0]);

            for ($i = 0; $i < $amountMatches; $i++) {
                // $array[0][$i] - совпадение, полное выражение совпадения
                // $array[2][$i] - название параметра или метода генерации
                // $array[4][$i] - аргументы метода генерации
                $matches[$array[0][$i]] = [
                    'name' =>   $array[2][$i],
                    'arguments' => $array[4][$i],
                ];
            }

            return $matches;
        }

        return [];
    }

    protected function defineRelationships($matches)
    {
        $relations = [];

        if (! empty($matches) && count($matches)) {
            foreach ($matches as $key => $value) {
                $relations[$value['name']] = $key;
            }

            return $relations;
        }

        return [];
    }

    /**
     * Возвращает сырые данные разбора указанной строки.
     *
     * @return mixed
     */
    public function getRawMatches()
    {
        return $this->rawMatches;
    }

    /**
     * Возвращает обработанное значение результата разбора строки.
     *
     * Значение состоит из ключа - выражения в исходной строке, и его
     * обработанных данных.
     *
     * @return mixed
     */
    public function getMatches()
    {
        return $this->matches;
    }

    /**
     * Возвращает данные указанного выражения.
     *
     * @param  string $expression
     * @return mixed
     */
    public function getMatch($expression)
    {
        return $this->matches[$expression] ?? [];
    }

    /**
     * Возвращает имя генератора по выражению.
     *
     * @param  string $expression
     * @return string
     */
    public function getGeneratorNameByExpression($expression)
    {
        return array_key_exists($expression, $this->matches)
                ? $this->matches[$expression]['name']
                : null;
    }

    public function getRelations()
    {
        return $this->relations;
    }

    /**
     * Возвращает необработанные аргументы указанного выражения.
     *
     * @param  string $expression
     * @return string
     */
    public function getGeneratorArguments($expression)
    {
        return array_key_exists($expression, $this->matches)
                ? $this->matches[$expression]['arguments']
                : '';
    }

    /**
     * Возвращает уникальные выражения шаблона.
     *
     * @return array
     */
    public function getExpressions()
    {
        return array_unique(array_keys($this->matches));
    }

    /**
     * Возвращает имена генераторов и строковые выражения.
     *
     * @return array
     */
    public function getGeneratorsNames()
    {
        return array_unique(array_keys($this->relations));
    }

}
