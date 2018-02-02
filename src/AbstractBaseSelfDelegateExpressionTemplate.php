<?php

namespace Dhii\Expression\Renderer;

use Dhii\Data\Container\ContainerAwareTrait;
use Dhii\Expression\ExpressionInterface;
use Dhii\Expression\TermInterface;

/**
 * Base functionality for expression templates that delegate the expression given to them to another renderer.
 *
 * This partial implementation is useful for creating "master" templates, which given any expression will delegate it
 * to the proper renderer or template, via an internal container instance.
 *
 * @since [*next-version*]
 */
abstract class AbstractBaseSelfDelegateExpressionTemplate extends AbstractBaseExpressionTemplate
{
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
        return $this->_delegateRenderTerm($expression, $context);
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

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    protected function _getTermTypeRendererContainer()
    {
        return $this->_getContainer();
    }
}
