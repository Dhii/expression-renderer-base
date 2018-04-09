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

        return implode($glueStr, $renderedTerms);
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    protected function _renderExpressionTerm(TermInterface $term, $context = null)
    {
        return sprintf('(%s)', parent::_renderExpressionTerm($term, $context));
    }
}
