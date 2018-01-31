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
abstract class AbstractBaseCommonExpressionTemplate extends AbstractBaseDelegatingExpressionTemplate
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
     * Retrieves the implosion glue to use for compiling an expression's full render result.
     *
     * @since [*next-version*]
     *
     * @param ExpressionInterface   $expression    The expression instance.
     * @param string[]|Stringable[] $renderedTerms TAn array of rendered terms.
     *
     * @return string|Stringable The implosion glue string.
     */
    protected function _getCompileExpressionTermsGlue(ExpressionInterface $expression, array $renderedTerms)
    {
        return $this->_getOperatorString();
    }
}
