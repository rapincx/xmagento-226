<?php

namespace ChaOS\PhpOop\ViewModel;

class ClassInformant implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    /**
     * @param $object
     * @return array
     * @throws \ReflectionException
     */
    public function getPublicMethods($object): array
    {
        $reflection = $this->reflectionFactory($object);
        $publicMethodsList = [];
        $publicMethods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
        foreach ($publicMethods as $currentObject) {
            $publicMethodsList[] = [
                'name' => $currentObject->name,
                'class' => $currentObject->class
            ];
        }
        return $publicMethodsList;
    }

    /**
     * @param $object
     * @return array
     * @throws \ReflectionException
     */
    public function getConstants($object): array
    {
        $parents = class_parents($object);
        $parents[\get_class($object)] = \get_class($object);
        $parents = array_reverse($parents);
        $constantsList = [];
        foreach ($parents as $className => $classData) {
            $obj = $this->reflectionFactory($className);
            $constantsList[$className] = $obj->getConstants();
        }
        return $constantsList;
    }

    /**
     * @param $object
     * @return \ReflectionClass
     * @throws \ReflectionException
     */
    private function reflectionFactory($object): \ReflectionClass
    {
        $argument = $object;
        if (\is_object($object)) {
            $argument = \get_class($object);
        }
        return new \ReflectionClass($argument);
    }
}