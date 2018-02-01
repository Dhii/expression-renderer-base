<?php

namespace Dhii\Expression\UnitTest;

use Dhii\Data\Container\Exception\NotFoundException;
use Dhii\Expression\Renderer\AbstractBaseCommonExpressionTemplate as TestSubject;
use Dhii\Expression\Renderer\ExpressionContextInterface;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Xpmock\TestCase;

/**
 * Tests {@see TestSubject}.
 *
 * @since [*next-version*]
 */
class AbstractBaseCommonExpressionTemplateTest extends TestCase
{
    /**
     * The class name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'Dhii\Expression\Renderer\AbstractBaseCommonExpressionTemplate';

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
     * Tests the render method to assert whether the result is the compilation of the rendered terms imploded by the
     * operator string.
     *
     * @since [*next-version*]
     */
    public function testRender()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);

        $expression = $this->createExpression(
            '',
            [
                $term1 = $this->createExpression($type1 = uniqid('type-')),
                $term2 = $this->createExpression($type2 = uniqid('type-')),
                $term3 = $this->createExpression($type3 = uniqid('type-')),
            ]
        );
        $render1 = uniqid('render-');
        $template1 = $this->createTemplate();
        $ctx1 = [ExpressionContextInterface::K_EXPRESSION => $term1];
        $template1->expects($this->atLeastOnce())->method('render')->with($ctx1)->willReturn($render1);

        $render2 = uniqid('render-');
        $template2 = $this->createTemplate();
        $ctx2 = [ExpressionContextInterface::K_EXPRESSION => $term2];
        $template2->expects($this->atLeastOnce())->method('render')->with($ctx2)->willReturn($render2);

        $render3 = uniqid('render-');
        $template3 = $this->createTemplate();
        $ctx3 = [ExpressionContextInterface::K_EXPRESSION => $term3];
        $template3->expects($this->atLeastOnce())->method('render')->with($ctx3)->willReturn($render3);

        $dlgCntr = $this->createContainer();
        $dlgCntr->method('get')->willReturnCallback(
            function($key) use ($type1, $type2, $type3, $template1, $template2, $template3) {
                switch ($key) {
                    case $type1:
                        return $template1;
                    case $type2:
                        return $template2;
                    case $type3:
                        return $template3;
                }
                throw new NotFoundException();
            }
        );
        $reflect->_setContainer($dlgCntr);

        $operator = uniqid('op-');
        $reflect->_setOperatorString($operator);

        $expected = "$render1 $operator $render2 $operator $render3";
        $context = [
            ExpressionContextInterface::K_EXPRESSION => $expression,
        ];

        $actual = $subject->render($context);

        $this->assertEquals($expected, $actual, 'Retrieved render result does not match expectation.');
    }
}
