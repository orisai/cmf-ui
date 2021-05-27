<?php declare(strict_types = 1);

namespace OriCMF\UI\ErrorForward\Presenter;

use Nette\Application\BadRequestException;
use Nette\Application\Request;
use Nette\Utils\Strings;
use OriCMF\UI\Front\Error\Presenter\ErrorPresenter;
use OriCMF\UI\Presenter\Base\BasePresenter;
use OriCMF\UI\Presenter\NoLogin;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Throwable;

final class ErrorForwardPresenter extends BasePresenter
{

	use NoLogin;

	private string $defaultErrorPresenter = ErrorPresenter::ACTION_DEFAULT;

	/** @var array<mixed> */
	private array $errorPresenters = [];

	public function __construct(private LoggerInterface $logger)
	{
		parent::__construct();
	}

	public function setDefaultErrorPresenter(string $presenter): void
	{
		$this->defaultErrorPresenter = $presenter;
	}

	public function addErrorPresenter(string $presenter, string $regex): void
	{
		$this->errorPresenters[] = [$presenter, $regex];
	}

	public function action(Throwable $exception, Request|null $request): void
	{
		// Log error
		$this->logger->log(
			$exception instanceof BadRequestException ? LogLevel::INFO : LogLevel::ERROR,
			$exception->getMessage(),
			[
				'presenter' => $request?->getPresenterName() ?? 'unknown',
				'exception' => $exception,
			],
		);

		// Forward to error presenter if matches pattern
		if ($request !== null) {
			foreach ($this->errorPresenters as [$presenter, $regex]) {
				if (Strings::match($request->getPresenterName(), $regex) !== null) {
					$this->forward($presenter, ['throwable' => $exception, 'request' => $request]);
				}
			}
		}

		// Forward to default error presenter
		$this->forward($this->defaultErrorPresenter, ['throwable' => $exception, 'request' => $request]);
	}

	protected function configureCanonicalUrl(): void
	{
		// Error presenter has no canonical url
	}

}
