<?php

namespace Dhii\Expression\Renderer;

use Dhii\Expression\ExpressionInterface;
use Dhii\Expression\TermInterface;
use Dhii\Output\TemplateAwareTrait;
use Exception as RootException;

/**
 * Base functionality for expression renderers that delegate term rendering to another renderer.
 *
 * This partial implementation traverses the expression and attempts to render its terms. Each term is passed onto a
 * single, internal delegate renderer instance. Very useful when the delegate renderer is a "master" renderer that can
 * render all term types.
 *
 * Implementors are only required to implement the `_compileExpressionTerms()` method to "compile" the rendered child
 * terms into the final expression render result.
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
     * Provides awareness of, and storage functionality for, a template instance.
     *
     * @since [*next-version*]
     */
    use TemplateAwareTrait;

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    protected function _renderExpression(TermInterface $expression, $context = null)
    {
        if ($expression instanceof ExpressionInterface) {
            return $this->_renderExpressionAndTerms($expression, $context);
        }

        return $this->_renderExpressionTerm($expression, $context);
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
        return $this->_getTemplate();
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    protected function _throwRendererException(
        $message = null,
        $code = null,
        RootException $previous = null
    ) {
        throw $this->_createRendererException($message, $code, $previous, $this);
    }
}
