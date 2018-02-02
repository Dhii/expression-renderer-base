<?php

namespace Dhii\Expression\UnitTest;

use Dhii\Expression\Renderer\AbstractBaseSelfDelegateExpressionTemplate as TestSubject;
use Dhii\Expression\Renderer\ExpressionContextInterface;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Xpmock\TestCase;

/**
 * Tests {@see TestSubject}.
 *
 * @since [*next-version*]
 */
class AbstractBaseSelfDelegateExpressionTemplateTest extends TestCase
{
    /**
     * The class name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'Dhii\Expression\Renderer\AbstractBaseSelfDelegateExpressionTemplate';

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @return MockObject
     */
    public function createInstance()
    {
        $mock = $this->getMockBuilder(static::TEST_SUBJECT_CLASSNAME)
                     ->setMethods([])
                     ->getMockForAbstractClass();

        return $mock;
    }

    /**
     * Creates a new expression mock instance.
     *
     * @since [*next-version*]
     *
     * @param string $type  The expression type.
     * @param array  $terms The expression terms.
     *
     * @return MockObject
     */
    public function createExpression($type = '', $terms = [])
    {
        $mock = $this->getMockBuilder('Dhii\Expression\ExpressionInterface')
                     ->setMethods(['getTerms', 'getType'])
                     ->getMockForAbstractClass();

        $mock->method('getType')->willReturn($type);
        $mock->method('getTerms')->willReturn($terms);

        return $mock;
    }

    /**
     * Creates a new container mock instance.
     *
     * @since [*next-version*]
     *
     * @return MockObject
     */
    public function createContainer()
    {
        $mock = $this->getMockBuilder('Dhii\Data\Container\ContainerInterface')
                     ->setMethods(['get', 'has'])
                     ->getMockForAbstractClass();

        return $mock;
    }

    /**
     * Creates a new template mock instance.
     *
     * @since [*next-version*]
     *
     * @return MockObject
     */
    public function createTemplate()
    {
        $mock = $this->getMockBuilder('Dhii\Output\TemplateInterface')
                     ->setMethods(['render'])
                     ->getMockForAbstractClass();

        return $mock;
    }

    /**
     * Tests whether a valid instance of the test subject can be created.
     *
     * @since [*next-version*]
     */
    public function testCanBeCreated()
    {
        $subject = $this->createInstance();

        $this->assertInstanceOf(
            static::TEST_SUBJECT_CLASSNAME,
            $subject,
            'A valid instance of the test subject could not be created.'
        );

        $this->assertInstanceOf(
            'Dhii\Output\TemplateInterface',
            $subject,
            'Test subject does not implement expected parent interface.'
        );
    }

    /**
     * Tests the render method to assert whether the result is the result returned by the delegate renderer.
     *
     * @since [*next-version*]
     */
    public function testRender()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);

        $expression = $this->createExpression($type = uniqid('type-'));
        $context = [
            ExpressionContextInterface::K_EXPRESSION => $expression,
        ];

        $expected = uniqid('result-');

        $dlgTemplate = $this->createTemplate();
        $dlgTemplate->method('render')->with($context)->willReturn($expected);

        $dlgContainer = $this->createContainer();
        $dlgContainer->method('get')->with($type)->willReturn($dlgTemplate);

        $reflect->_setTermTypeRendererContainer($dlgContainer);

        $actual = $subject->render($context);

        $this->assertEquals($expected, $actual, 'Retrieved render result does not match expectation.');
    }
}
