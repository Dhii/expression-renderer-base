<?php

namespace Dhii\Expression\Renderer;

use Dhii\Expression\ExpressionInterface;
use Dhii\Expression\TermInterface;

/**
 * Base implementation that provides common functionality for operator-style expression templates.
 *
 * This partial implementation provides term render delegation via a container, term render compilation via imploding
 * rendered terms as operands and operator string awareness for use as an imploding glue.
 *
 * @since [*next-version*]
 */
abstract class AbstractBaseOperatorExpressionTemplate extends AbstractBaseDelegateExpressionTemplate
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
        $glueStr = sprintf(' %s ', $opStr);
        $joined = implode($glueStr, $renderedTerms);

        return sprintf('(%s)', $joined);
    }
}
