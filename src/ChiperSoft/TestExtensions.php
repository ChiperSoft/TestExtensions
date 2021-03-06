<?php

namespace ChiperSoft;

/**
 * Some useful methods to make testing with PHPUnit faster and more fun
 *
 * @author Jarvis Badgley <chiper@chipersoft.com> and Juan Treminio <jtreminio@gmail.com>
 */
trait TestExtensions {

    /**
     * Set protected/private attribute of object
     *
     * @param object &$object       Object containing attribute
     * @param string $attributeName Attribute name to change
     * @param string $value         Value to set attribute to
     *
     * @return null
     */
    public function setAttribute(&$object, $attributeName, $value)
    {
        $class = is_object($object) ? get_class($object) : $object;

        $reflection = new \ReflectionProperty($class, $attributeName);
        $reflection->setAccessible(true);
        $reflection->setValue($object, $value);
    }

    /**
     * Get protected/private attribute of object
     *
     * @param object &$object       Object containing attribute
     * @param string $attributeName Attribute name to fetch
     * @return mixed
     */
    public function getAttribute(&$object, $attributeName)
    {
        $class = is_object($object) ? get_class($object) : $object;

        $reflection = new \ReflectionProperty($class, $attributeName);
        $reflection->setAccessible(true);
        return $reflection->getValue($object);
    }

    /**
     * Call protected/private method of a class. Pass any function arguments after the method name
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     *
     * @return mixed Method return.
     */
    public function invokeMethod(&$object, $methodName)
    {

        $parameters = func_get_args();
        $parameters = array_slice($parameters, 2);

        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

}