# Dhii - Expression - Renderer - Base

[![Build Status](https://travis-ci.org/Dhii/expression-renderer-base.svg?branch=develop)](https://travis-ci.org/Dhii/expression-renderer-base)
[![Code Climate](https://codeclimate.com/github/Dhii/expression-renderer-base/badges/gpa.svg)](https://codeclimate.com/github/Dhii/expression-renderer-base)
[![Test Coverage](https://codeclimate.com/github/Dhii/expression-renderer-base/badges/coverage.svg)](https://codeclimate.com/github/Dhii/expression-renderer-base/coverage)
[![Latest Stable Version](https://poser.pugx.org/Dhii/expression-renderer-base/version)](https://packagist.org/packages/Dhii/expression-renderer-base)
[![This package complies with Dhii standards](https://img.shields.io/badge/Dhii-Compliant-green.svg?style=flat-square)][Dhii]


## Details
Base functionality for expression renderers.

### Classes
- [`AbstractBaseExpressionTemplate`] - Provides common functionality for expression renderers, such as reading the
expression from the context, factory methods for exceptions, string normalization, etc.
- [`AbstractBaseDelegateExpressionTemplate`] - Provides delegation and container awareness for renderers that need to
delegate the renderer of an expression's terms to other renderers.
- [`AbstractBaseOperatorExpressionTemplate`] - Provides functionality for rendering expressions as operators, with their
terms rendered via delegate templates as operands.
- [`AbstractBaseSelfDelegateExpressionTemplate`] - Provides functionality for creating master renderers, that delegate
_all_ expressions to other renderers.


[Dhii]:                                                     https://github.com/Dhii/dhii

[`AbstractBaseExpressionTemplate`]:                         src/AbstractBaseExpressionTemplate.php
[`AbstractBaseDelegateExpressionTemplate`]:                 src/AbstractBaseDelegateExpressionTemplate.php 
[`AbstractBaseOperatorExpressionTemplate`]:                 src/AbstractBaseOperatorExpressionTemplate.php 
[`AbstractBaseSelfDelegateExpressionTemplate`]:             src/AbstractBaseSelfDelegateExpressionTemplate.php 
