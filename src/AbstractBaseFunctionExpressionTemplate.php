<?php

namespace Dhii\Expression\Renderer;

use Dhii\Expression\ExpressionInterface;

/**
 * Base implementation that provides common functionality for function-style expression templates.
 *
 * This partial implementation provides term render delegation via a container, term render compilation via imploding
 * rendered terms as arguments and operator string awareness for use as the function name.
 *
 * @since [*next-version*]
 */
abstract class AbstractBaseFunctionExpressionTemplate extends AbstractBaseDelegateExpressionTemplate
{
    /*
     * Provides awareness of an operator string.
     *
     * @since [*next-version*]
     */
    use OperatorStringAwareTrait;

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    protected function _compileExpressionTerms(
        ExpressionInterface $expression,
        array $renderedTerms,
        $context = null
    ) {
        $opStr = $this->_getOperatorString();
        $argsStr = implode(', ', $renderedTerms);

        return sprintf('%1$s(%2$s)', $opStr, $argsStr);
    }
}
