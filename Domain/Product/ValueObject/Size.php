<?php

namespace Lash\Domain\Product\ValueObject;

use Lash\Domain\EnumerableValueObjectInterface;
use Lash\Domain\Product\Exception\WrongSizeException;

class Size implements EnumerableValueObjectInterface
{
	/**
	 * @var string
	 */
	public const XS = 'xs';

	/**
	 * @var string
	 */
	public const S = 's';

	/**
	 * @var string
	 */
	public const M = 'm';

	/**
	 * @var string
	 */
	public const L = 'l';

	/**
	 * @var string
	 */
	public const XL = 'xl';

	/**
	 * @var string
	 */
	public const XXL = 'xxl';

	/**
	 * @var string
	 */
	public const XXXL = 'xxxl';

	/**
	 * @var string
	 */
	public const XXXXL = 'xxxxl';

	/**
	 * @var string
	 */
	private $size;

	/**
	 * Size constructor.
	 * @param string $size
	 */
	public function __construct(string $size)
	{
		if (!self::isValid($size)) {
			throw new WrongSizeException(sprintf('Size "%s" is unknown.', $size));
		}
		$this->size = $size;
	}

	/**
	 * @inheritdoc
	 */
	public function toString(): string
	{
		return $this->size;
	}

	/**
	 * @inheritdoc
	 */
	public function equals(EnumerableValueObjectInterface $valueObject): bool
	{
		return $this->toString() === $valueObject->toString();
	}

	/**
	 * @inheritdoc
	 */
	public static function isValid($value): bool
	{
		return \in_array($value, self::getAll(), true);
	}

	/**
	 * Returns all possible size values.
	 *
	 * @return array
	 */
	public static function getAll(): array
	{
		return [
			self::XS,
			self::S,
			self::M,
			self::L,
			self::XL,
			self::XXL,
			self::XXXL,
			self::XXXXL,
		];
	}
}
