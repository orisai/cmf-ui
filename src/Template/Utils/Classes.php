<?php declare(strict_types = 1);

namespace OriCMF\UI\Template\Utils;

use ReflectionClass;
use function class_parents;
use function dirname;
use function get_class;

/**
 * @internal
 * @todo - move
 */
final class Classes
{

	/**
	 * @return array<string>
	 * @phpstan-return array<class-string>
	 */
	public static function getClassList(object $object): array
	{
		$called = get_class($object);

		return [$called] + class_parents($called);
	}

	/**
	 * @phpstan-param class-string $class
	 */
	public static function getClassDir(string $class): string
	{
		$reflection = new ReflectionClass($class);

		return dirname($reflection->getFileName());
	}

}
