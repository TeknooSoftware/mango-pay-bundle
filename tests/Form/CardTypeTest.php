<?php

namespace UniAlteri\MangoPayBundle\Tests\Form;

use UniAlteri\MangoPayBundle\Form\Type\CardType;

/**
 * Class CardTypeTest
 * @package UniAlteri\MangoPayBundle\Tests\Form
 * @covers UniAlteri\MangoPayBundle\Form\Type\CardType
 */
class CardTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return CardType
     */
    public function buildService()
    {
        return new CardType();
    }

    public function testBuildForm()
    {
        $builderMock = $this->getMock('Symfony\Component\Form\FormBuilderInterface', [], [], '', false);
        $neededFields = array_flip(['data', 'accessKeyRef', 'returnURL', 'cardNumber', 'cardExpirationDate', 'cardCvx']);
        $builderMock
            ->expects($this->atLeast(6))
            ->method('add')
            ->willReturnCallback(
                function ($name, $type, array $options = array()) use ($builderMock, &$neededFields) {
                    if (isset($neededFields[$name])) {
                        unset($neededFields[$name]);

                        switch ($name) {
                            case 'data':
                                $this->assertEquals('hidden', $type);
                                $this->assertTrue($options['mapped']);
                                break;
                            case 'accessKeyRef':
                                $this->assertEquals('hidden', $type);
                                $this->assertTrue($options['mapped']);
                                break;
                            case 'returnURL':
                                $this->assertEquals('hidden', $type);
                                $this->assertTrue($options['mapped']);
                                break;
                            case 'cardNumber':
                                $this->assertEquals('text', $type);
                                $this->assertFalse($options['mapped']);
                                break;
                            case 'cardExpirationDate':
                                $this->assertEquals('text', $type);
                                $this->assertFalse($options['mapped']);
                                $this->assertEquals('[0-1]{1}[0-9]{1}[0-9]{2}', $options['attr']['pattern']);
                                break;
                            case 'cardCvx':
                                $this->assertEquals('text', $type);
                                $this->assertFalse($options['mapped']);
                                break;
                        }
                    }

                    return $builderMock;
                }
            );

        $this->buildService()->buildForm($builderMock, []);
        if (!empty($neededFields)) {
            $this->fail('Form need fields '.implode(array_flip($neededFields)));
        }
    }

    public function testGetNameNull()
    {
        $this->assertNull($this->buildService()->getName());
    }
}