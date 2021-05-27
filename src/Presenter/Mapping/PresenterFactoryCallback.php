<?php declare(strict_types = 1);

namespace OriCMF\UI\Presenter\Mapping;

use Nette\Application\InvalidPresenterException;
use Nette\Application\IPresenter;
use Nette\DI\Container;
use function array_shift;
use function assert;
use function count;
use function implode;
use function sprintf;

final class PresenterFactoryCallback
{

	public function __construct(private Container $container)
	{
	}

	public function __invoke(string $class): IPresenter
	{
		$services = $this->container->findByType($class);

		if ($services === []) {
			throw new InvalidPresenterException(sprintf(
				'Presenter "%s" is not registered as a service.',
				$class,
			));
		}

		if (count($services) !== 1) {
			throw new InvalidPresenterException(sprintf(
				'Multiple services of type "%s" found: %s.',
				$class,
				implode(', ', $services),
			));
		}

		$service = $this->container->createService(array_shift($services));
		assert($service instanceof IPresenter);

		return $service;
	}

}
