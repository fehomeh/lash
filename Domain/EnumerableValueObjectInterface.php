<?php

namespace Lash\Domain;

interface EnumerableValueObjectInterface
{
	/**
	 * Checks if current object equals to given.
	 *
	 * @param EnumerableValueObjectInterface $valueObject
	 *
	 * @return bool
	 */
	public function equals(EnumerableValueObjectInterface $valueObject): bool;

	/**
	 * Returns string representation of object's value.
	 *
	 * @return string
	 */
	public function toString(): string;

	/**
	 * Checks if given value is valid for current ValueObject.
	 *
	 * @param mixed $value
	 *
	 * @return bool
	 */
	public static function isValid($value): bool;

	/**
	 * Returns all possible values for the object.
	 *
	 * @return array
	 */
	public static function getAll(): array;
}
