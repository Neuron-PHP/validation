<?php

namespace Neuron\Validation;

/**
 * Core validator interface for the Neuron validation system.
 * 
 * This interface defines the contract that all validators must implement
 * within the Neuron validation framework. It provides a consistent API
 * for validating data across different types and validation rules,
 * enabling composable and reusable validation logic throughout applications.
 * 
 * Key features:
 * - Simple boolean validation result for easy integration
 * - Support for any data type through mixed parameter
 * - Foundation for complex validation rule composition
 * - Consistent API across 20+ built-in validators
 * - Extensible for custom validation implementations
 * 
 * Common validator implementations:
 * - Format validators: IsEmail, IsUrl, IsPhoneNumber, IsJson
 * - Type validators: IsString, IsInteger, IsArray, IsBoolean
 * - Range validators: IsNumberWithinRange, IsStringLength
 * - Pattern validators: IsRegExPattern, IsName
 * - Business validators: IsEin, IsUpc, IsCurrency
 * 
 * @package Neuron\Validation
 * 
 * @example
 * ```php
 * // Custom validator implementation
 * class IsPositiveNumber implements IValidator
 * {
 *     public function isValid(mixed $value): bool
 *     {
 *         return is_numeric($value) && $value > 0;
 *     }
 * }
 * 
 * // Usage with validation policies
 * $policy = new Policy();
 * $policy->add('amount', new IsPositiveNumber());
 * $policy->add('email', new IsEmail());
 * 
 * $result = $policy->validate([
 *     'amount' => 25.99,
 *     'email' => 'user@example.com'
 * ]);
 * ```
 */
interface IValidator
{
	/**
	 * Determines if the provided value meets the validity criteria.
	 *
	 * @param mixed $Value The value to be validated.
	 * @return bool Returns true if the value is valid, otherwise false.
	 */
	public function isValid( mixed $Value ) : bool;
}
