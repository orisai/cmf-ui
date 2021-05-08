<?php declare(strict_types = 1);

namespace OriCMF\UI\Admin\Error\Presenter;

use Nette\Application\BadRequestException;
use Nette\Http\IResponse;
use OriCMF\UI\Admin\Base\Presenter\BaseAdminPresenter;
use Throwable;
use function in_array;
use function sprintf;

/**
 * @property-read ErrorTemplate $template
 */
final class ErrorPresenter extends BaseAdminPresenter
{

	public const ACTION_DEFAULT = ':OriCMF:UI:Admin:Error:default';

	protected const SUPPORTED_VIEWS = [400, 403, 404, 410, 500];

	public function actionDefault(): void
	{
		// Note error in ajax request
		if ($this->isAjax()) {
			$this->payload->error = true;
			$this->sendPayload();
		}
	}

	public function renderDefault(Throwable|null $throwable = null): void
	{
		if ($throwable === null) {
			// Direct access, act as user error
			$code = IResponse::S404_NOT_FOUND;
			$view = 404;
		} elseif ($throwable instanceof BadRequestException) {
			// Use view requested by BadRequestException or generic 404/500
			$code = $throwable->getCode();
			if (in_array($code, self::SUPPORTED_VIEWS, true)) {
				$view = $code;
			} else {
				$view = $code >= 400 && $code <= 499 ? 404 : 500;
			}
		} else {
			// Use generic view for real error
			$code = IResponse::S500_INTERNAL_SERVER_ERROR;
			$view = 500;
		}

		// Set page title
		$this['document']->setTitle(
			$this->translator->translate(sprintf(
				'ori.ui.httpError.%s.title',
				$view,
			)),
		);

		$this->getHttpResponse()->setCode($code);
		$this->setView((string) $view);
	}

	protected function configureCanonicalUrl(): void
	{
		// Error presenter has no canonical url
	}

}
