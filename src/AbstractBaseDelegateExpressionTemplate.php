<?php

namespace Dhii\Expression\Renderer;

use Dhii\Data\Container\ContainerAwareTrait;
use Dhii\Expression\ExpressionInterface;
use Dhii\Expression\TermInterface;

/**
 * Base functionality for expression renderers that delegate term rendering to other renderers.
 *
 * This partial implementation traverses the expression and attempts to render its terms. Each term is passed onto a
 * delegate renderer obtained from an internal container instance.
 *
 * Implementors are only required to implement the `_compileExpressionTerms()` method.
 *
 * @since [*next-version*]
 */
abstract class AbstractBaseDelegateExpressionTemplate extends AbstractBaseExpressionTemplate
{
    /*
     * Provides functionality for traversing the expression, rendering its terms, then compiling the result.
     *
     * @since [*next-version*]
     */
    use RenderExpressionAndTermsCapableTrait;

    /*
     * Provides functionality for delegating the rendering of terms to other renderers.
     *
     * @since [*next-version*]
     */
    use DelegateRenderTermCapableTrait;

    /*
     * Provides functionality for resolving delegate renderers via a container, using the term's type as key.
     *
     * @since [*next-version*]
     */
    use GetTermTypeRendererContainerTrait;

    /*
     * Provides awareness of, and storage functionality for, a container instance.
     *
     * @since [*next-version*]
     */
    use ContainerAwareTrait {
        _getContainer as _getTermTypeRendererContainer;
        _setContainer as _setTermTypeRendererContainer;
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    protected function _renderExpression(ExpressionInterface $expression, $context = null)
    {
        return $this->_renderExpressionAndTerms($expression, $context);
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    protected function _renderExpressionTerm(TermInterface $term, $context = null)
    {
        return $this->_delegateRenderTerm($term, $context);
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    protected function _getTermDelegateRenderer(TermInterface $term, $context = null)
    {
        return $this->_getTermTypeRenderer($term->getType());
    }
}
