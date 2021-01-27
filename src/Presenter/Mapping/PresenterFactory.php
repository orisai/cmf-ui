<?php declare(strict_types = 1);

namespace OriCMF\UI\Presenter\Mapping;

use Nepada\PresenterMapping\PresenterFactory as BasePresenterFactory;
use function ltrim;

final class PresenterFactory extends BasePresenterFactory
{

	public function getPresenterClass(string &$name): string
	{
		$name = ltrim($name, ':');

		return parent::getPresenterClass($name);
	}

	public function formatPresenterClass(string $presenter): string
	{
		$presenter = ltrim($presenter, ':');

		return parent::formatPresenterClass($presenter);
	}

}
