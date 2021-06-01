<?php declare(strict_types = 1);

namespace OriCMF\UI\Presenter\Mapping;

use Nepada\PresenterMapping\PresenterFactory as BasePresenterFactory;
use function class_exists;
use function is_string;
use function str_starts_with;
use function substr;

final class PresenterFactory extends BasePresenterFactory
{

	/** @var array<string|array<string>> */
	private array $mapping;

	public function getPresenterClass(string &$name): string
	{
		if (class_exists($name)) {
			$newName = $this->mapping[$name] ?? null;
			if (is_string($newName)) {
				return $newName;
			}

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
			$newName = $this->mapping[$presenter] ?? null;
			if (is_string($newName)) {
				return $newName;
			}

			return $presenter;
		}

		if (str_starts_with($presenter, ':')) {
			$presenter = substr($presenter, 1);
		}

		return parent::formatPresenterClass($presenter);
	}

	/**
	 * @param array<string|array<string>> $mapping $mapping
	 * @return $this
	 */
	public function setMapping(array $mapping): self
	{
		$this->mapping = $mapping;

		/** @phpstan-ignore-next-line */
		return parent::setMapping($mapping);
	}

}
