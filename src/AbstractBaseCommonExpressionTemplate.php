<?php

namespace Dhii\Expression\Renderer;

use Dhii\Expression\ExpressionInterface;
use Dhii\Util\String\StringableInterface as Stringable;

/**
 * Base implementation that provides the most common functionality for expression templates.
 *
 * This partial implementation provides term render delegation via a container, term render compilation via imploding
 * and operator string awareness for use as an imploding glue.
 *
 * @since [*next-version*]
 */
abstract class AbstractBaseCommonExpressionTemplate extends AbstractBaseDelegateExpressionTemplate
{
    /*
     * Provides functionality for compiling expression terms via imploding.
     *
     * @since [*next-version*]
     */
    use CompileExpressionTermsImplodeTrait;

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
    protected function _getCompileExpressionTermsGlue(
        ExpressionInterface $expression,
        array $renderedTerms,
        $context = null
    ) {
        return sprintf(' %s ', $this->_getOperatorString());
    }
}
