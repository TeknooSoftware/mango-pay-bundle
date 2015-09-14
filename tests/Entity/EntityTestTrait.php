<?php

/**
 * MangoPayBundle.
 *
 * LICENSE
 *
 * This source file is subject to the MIT license and the version 3 of the GPL3
 * license that are bundled with this package in the folder licences
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to contact@uni-alteri.com so we can send you a copy immediately.
 *
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
 *
 * @link        http://teknoo.it/mangopay-bundle Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */

namespace UniAlteri\MangoPayBundle\Tests\Entity;

/**
 * Trait EntityTestTrait
 *
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
 *
 * @link        http://teknoo.it/mangopay-bundle Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 *
 * Trait to test an entity.
 */
trait EntityTestTrait
{
    /**
     * @var \ReflectionClass
     */
    protected $reflectionClass;

    /**
     * @var object
     */
    protected $testedEntity;

    /**
     * Return the canonical class name of the tested entity.
     *
     * @return string
     */
    abstract protected function getEntityClassName();

    /**
     * Reflection class instance about tested entity.
     *
     * @return \ReflectionClass
     */
    protected function getReflectionClass()
    {
        if (!$this->reflectionClass instanceof \ReflectionClass) {
            $this->reflectionClass = new \ReflectionClass($this->getEntityClassName());
        }

        return $this->reflectionClass;
    }

    /**
     * Return an instance of the tested entity.
     *
     * @param array $properties
     *
     * @return object
     */
    protected function buildEntity(array $properties = array())
    {
        $this->testedEntity = null;

        //Build a new instance of this object
        $entityClassName = $this->getEntityClassName();
        $entityObject = new $entityClassName();

        if (!empty($properties)) {
            //We must populate the object's var, we use ReflectionClass api to bypass visibility scope constraints
            $reflectionClassObject = $this->getReflectionClass();

            //Populate arguments
            foreach ($properties as $propertyName => &$value) {
                if ($reflectionClassObject->hasProperty($propertyName)) {
                    $propertyObject = $reflectionClassObject->getProperty($propertyName);
                    $propertyObject->setAccessible(true);
                    $propertyObject->setValue($entityObject, $value);
                }
            }
        }

        $this->testedEntity = $entityObject;

        return $entityObject;
    }

    /**
     * Method to check a getter behavior of the entity class.
     *
     * @param string      $propertyName
     * @param mixed       $testValue
     * @param string|null $getterName
     *
     * @return $this
     */
    protected function checkGetter($propertyName, $testValue, $getterName = null)
    {
        //Get Reflection
        $entityClassName = $this->getEntityClassName();
        $reflectionClassObject = $this->getReflectionClass();

        //Check if the property exists
        if ($reflectionClassObject->hasProperty($propertyName)) {
            $propertyObject = $reflectionClassObject->getProperty($propertyName);
            if (empty($getterName)) {
                $getterName = 'get'.ucfirst($propertyName);
            }

            //Test with a tested value
            $entityInstance = $this->buildEntity([$propertyName => $testValue]);
            $this->assertEquals($testValue, $entityInstance->{$getterName}());
        } else {
            $this->fail(sprintf('Error, property %s is not available for %s', $propertyName, $entityClassName));
        }

        return $this;
    }

    /**
     * Method to check a setter behavior of the entity class.
     *
     * @param string      $propertyName
     * @param string      $testValue
     * @param string|null $setterName
     *
     * @return $this
     */
    protected function checkSetter($propertyName, $testValue, $setterName = null)
    {
        //Get Reflection
        $entityClassName = $this->getEntityClassName();
        $reflectionClassObject = $this->getReflectionClass();

        //Check if the property exists
        if ($reflectionClassObject->hasProperty($propertyName)) {
            $propertyObject = $reflectionClassObject->getProperty($propertyName);
            if (empty($setterName)) {
                $setterName = 'set'.ucfirst($propertyName);
            }

            //Test with a tested value
            $entityInstance = $this->buildEntity();
            $this->assertSame($entityInstance, $entityInstance->{$setterName}($testValue));
            $propertyObject->setAccessible(true);
            $this->assertEquals($testValue, $propertyObject->getValue($entityInstance));
        } else {
            $this->fail(sprintf('Error, property %s is not available for %s', $propertyName, $entityClassName));
        }

        return $this;
    }
}
