<?php declare(strict_types = 1);

namespace OriCMF\UI\Presenter\Mapping;

use Nepada\PresenterMapping\PresenterFactory as BasePresenterFactory;
use function class_exists;
use function str_starts_with;
use function substr;

final class PresenterFactory extends BasePresenterFactory
{

	public function getPresenterClass(string &$name): string
	{
		if (class_exists($name)) {
			return $name;
		}

		if (str_starts_with($name, ':')) {
			$name = substr($name, 1);
		}

		return parent::getPresenterClass($name);
	}

	public function formatPresenterClass(string $presenter): string
	{
		if (class_exists($presenter)) {
			return $presenter;
		}

		if (str_starts_with($presenter, ':')) {
			$presenter = substr($presenter, 1);
		}

		return parent::formatPresenterClass($presenter);
	}

}
