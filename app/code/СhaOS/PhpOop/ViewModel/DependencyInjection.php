<?php

namespace ChaOS\PhpOop\ViewModel;

/**
 * Class DependencyInjection
 * @package ChaOS\PhpOop\ViewModel
 */
class DependencyInjection implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    /**
     * This params are used in Reflection
     */
    public $stringParam;
    public $instanceParam;
    public $boolParam;
    public $intParam;
    public $globalInitParam;
    public $constantParam;
    public $optionalParam;
    public $arrayParam;

    public function __construct(
        $stringParam,
        $instanceParam,
        $boolParam,
        $intParam,
        $globalInitParam,
        $constantParam,
        $optionalParam,
        $arrayParam
    )
    {
        $this->stringParam = $stringParam;
        $this->instanceParam = $instanceParam;
        $this->boolParam = $boolParam;
        $this->intParam = $intParam;
        $this->globalInitParam = $globalInitParam;
        $this->constantParam = $constantParam;
        $this->optionalParam = $optionalParam;
        $this->arrayParam = $arrayParam;
    }

    public function getArguments()
    {
        $params = get_object_vars($this);
        return $params;
    }
}