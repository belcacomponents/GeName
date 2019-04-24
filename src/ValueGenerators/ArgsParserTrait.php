<?php

namespace Belca\GeName\ValueGenerators;

/**
 * Разбирает значения аргументов и сохраняет их.
 */
trait ArgsParserTrait
{
    /**
     * Устанавливает аргументы функции в сыром виде.
     *
     * @param string $rawArgs
     */
    public function setRawArgs($rawArgs)
    {
        $this->rawArgs = $rawArgs;
        $this->args = $this->argsParser($rawArgs);
    }

    /**
     * Разбирает указанную строку аргументов на список значений для генераторов.
     *
     * @param  string $rawArgs
     * @return mixed
     */
    protected function argsParser($rawArgs)
    {
        $args = [];

        if (! empty($rawArgs) && is_string($rawArgs)) {
            $argsTmp = explode($this->getArgumentDelimiter(), $rawArgs);

            if (count($argsTmp) >= 1) {
                foreach ($argsTmp as $argTmp) {
                    $paramsTmp = explode($this->getParameterDelimiter(), $argsTmp[0]);

                    // Сохраняем только те значения, которые не имеют значений,
                    // только имя (равносильно true) и имеют одно значение.
                    if (count($paramsTmp) == 2) {
                        $args[$paramsTmp[0]] = $paramsTmp[1];
                    } elseif (count($paramsTmp) == 1) {
                        $args[$paramsTmp[0]] = true;
                    }
                }
            }
        }

        return $args;
    }

    /**
     * Возвращает разделитель переданных аргументов.
     *
     * @return string
     */
    protected function getArgumentDelimiter()
    {
        return ';';
    }

    /**
     * Возвращает разделитель параметров функции.
     *
     * @return string
     */
    protected function getParameterDelimiter()
    {
        return ':';
    }
}
