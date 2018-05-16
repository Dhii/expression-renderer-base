<?php

namespace Dhii\Expression\UnitTest;

use Dhii\Data\Container\Exception\NotFoundException;
use Dhii\Expression\Renderer\AbstractBaseFunctionExpressionTemplate as TestSubject;
use Dhii\Expression\Renderer\ExpressionContextInterface;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Xpmock\TestCase;

/**
 * Tests {@see TestSubject}.
 *
 * @since [*next-version*]
 */
class AbstractBaseFunctionExpressionTemplateTest extends TestCase
{
    /**
     * The class name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'Dhii\Expression\Renderer\AbstractBaseFunctionExpressionTemplate';

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
                     ->setMethods(['_normalizeKey'])
                     ->getMockForAbstractClass();

        $mock->method('_normalizeKey')->willReturnArgument(0);

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
     * Tests the render method to assert whether the result is the compilation of the rendered terms imploded by a
     * comma as arguments to a function.
     *
     * @since [*next-version*]
     */
    public function testRender()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);

        $expression = $this->createExpression(
            '',
            $childTerms = [
                $term1 = $this->createExpression($type1 = uniqid('type-')),
                $term2 = $this->createExpression($type2 = uniqid('type-')),
                $term3 = $this->createExpression($type3 = uniqid('type-')),
            ]
        );

        // Internal delegate template getter method, called for each child term
        $dlgTemplate = $this->createTemplate();
        $reflect->_setTemplate($dlgTemplate);

        // Delegate template contexts and render results
        $ctx1 = [ExpressionContextInterface::K_EXPRESSION => $term1];
        $ctx2 = [ExpressionContextInterface::K_EXPRESSION => $term2];
        $ctx3 = [ExpressionContextInterface::K_EXPRESSION => $term3];
        $render1 = uniqid('render1-');
        $render2 = uniqid('render2-');
        $render3 = uniqid('render3-');

        // Mock render results from delegate template
        $dlgTemplate->expects($this->exactly(count($childTerms)))
                    ->method('render')
                    ->withConsecutive([$ctx1], [$ctx2], [$ctx3])
                    ->willReturnOnConsecutiveCalls($render1, $render2, $render3);

        $operator = uniqid('op-');
        $reflect->_setOperatorString($operator);

        $expected = "$operator($render1, $render2, $render3)";
        $context = [
            ExpressionContextInterface::K_EXPRESSION => $expression,
        ];

        $actual = $subject->render($context);

        $this->assertEquals($expected, $actual, 'Retrieved render result does not match expectation.');
    }
}
