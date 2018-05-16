<?php

namespace Dhii\Expression\UnitTest;

use Dhii\Expression\Renderer\AbstractBaseExpressionTemplate as TestSubject;
use Dhii\Expression\Renderer\ExpressionContextInterface;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Xpmock\TestCase;

/**
 * Tests {@see TestSubject}.
 *
 * @since [*next-version*]
 */
class AbstractBaseExpressionTemplateTest extends TestCase
{
    /**
     * The class name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'Dhii\Expression\Renderer\AbstractBaseExpressionTemplate';

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
                     ->setMethods(['_renderExpression', '_normalizeKey'])
                     ->getMockForAbstractClass();

        $mock->method('_normalizeKey')->willReturnArgument(0);

        return $mock;
    }

    /**
     * Creates a new expression mock instance.
     *
     * @since [*next-version*]
     *
     * @return MockObject
     */
    public function createExpression()
    {
        $mock = $this->getMockBuilder('Dhii\Expression\ExpressionInterface')
                     ->setMethods(['getTerms', 'getType'])
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
     * Tests the render method with an invalid context to assert whether a correct exception is thrown.
     *
     * @since [*next-version*]
     */
    public function testRender()
    {
        $subject = $this->createInstance();

        $expression = $this->createExpression();
        $expected = uniqid('render-result-');
        $context = [
            ExpressionContextInterface::K_EXPRESSION => $expression,
        ];

        $subject->expects($this->once())
                ->method('_renderExpression')
                ->with($expression)
                ->willReturn($expected);

        $actual = $subject->render($context);

        $this->assertEquals($expected, $actual, 'Retrieved render result does not match expectation.');
    }

    /**
     * Tests the render method with an invalid context to assert whether a correct exception is thrown.
     *
     * @since [*next-version*]
     */
    public function testRenderInvalidContext()
    {
        $subject = $this->createInstance();

        $expression = $this->createExpression();
        $context = [
            uniqid('some-key-') => $expression,
        ];

        $this->setExpectedException('InvalidArgumentException');

        $subject->render($context);
    }

    /**
     * Tests the render method without a context to assert whether a correct exception is thrown.
     *
     * @since [*next-version*]
     */
    public function testRenderNoContext()
    {
        $subject = $this->createInstance();

        $this->setExpectedException('InvalidArgumentException');

        $subject->render();
    }
}
