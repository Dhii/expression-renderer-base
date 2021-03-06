<?php

namespace Dhii\Expression\Renderer;

use Dhii\Data\Container\ContainerGetCapableTrait;
use Dhii\Data\Container\CreateContainerExceptionCapableTrait;
use Dhii\Data\Container\CreateNotFoundExceptionCapableTrait;
use Dhii\Data\Container\NormalizeContainerCapableTrait;
use Dhii\Data\Container\NormalizeKeyCapableTrait;
use Dhii\Exception\CreateInvalidArgumentExceptionCapableTrait;
use Dhii\Exception\CreateOutOfRangeExceptionCapableTrait;
use Dhii\I18n\StringTranslatingTrait;
use Dhii\Output\CreateRendererExceptionCapableTrait;
use Dhii\Output\CreateTemplateRenderExceptionCapableTrait;
use Dhii\Output\TemplateInterface;
use Dhii\Util\Normalization\NormalizeStringCapableTrait;
use Exception as RootException;

/**
 * Base functionality for expression templates.
 *
 * This partial implementation provides the basic functionality for extracting the expression from a render context,
 * creating the appropriate exceptions and implementing the template API.
 *
 * Implementors are only required to implement the `_renderExpression()` method.
 *
 * @since [*next-version*]
 */
abstract class AbstractBaseExpressionTemplate implements TemplateInterface
{
    /*
     * Provides basic functionality for extracting the expression from the render context.
     *
     * @since [*next-version*]
     */
    use RenderExpressionTrait;

    /*
     * Provides functionality for reading data from any type of container object.
     *
     * @since [*next-version*]
     */
    use ContainerGetCapableTrait;

    /*
     * Provides container normalization functionality.
     *
     * @since [*next-version*]
     */
    use NormalizeContainerCapableTrait;

    /*
     * Provides key normalization functionality.
     *
     * @since [*next-version*]
     */
    use NormalizeKeyCapableTrait;

    /*
     * Provides string normalization functionality.
     *
     * @since [*next-version*]
     */
    use NormalizeStringCapableTrait;

    /*
     * Provides functionality for creating invalid argument exception instances.
     *
     * @since [*next-version*]
     */
    use CreateInvalidArgumentExceptionCapableTrait;

    /*
     * Provides functionality for creating out-of-range exception instances.
     *
     * @since [*next-version*]
     */
    use CreateOutOfRangeExceptionCapableTrait;

    /**
     * Provides functionality for creating container exception instances.
     *
     * @since [*next-version*]
     */
    use CreateContainerExceptionCapableTrait;

    /*
     * Provides functionality for creating container not-found exception instances.
     *
     * @since [*next-version*]
     */
    use CreateNotFoundExceptionCapableTrait;

    /*
     * Provides functionality for creating renderer exception instances.
     *
     * @since [*next-version*]
     */
    use CreateRendererExceptionCapableTrait;

    /*
     * Provides functionality for creating template render exception instances.
     *
     * @since [*next-version*]
     */
    use CreateTemplateRenderExceptionCapableTrait;

    /*
     * Provides string translation functionality.
     *
     * @since [*next-version*]
     */
    use StringTranslatingTrait;

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function render($context = null)
    {
        return $this->_render($context);
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
        return $this->_createRendererException($message, $code, $previous, $this);
    }
}
