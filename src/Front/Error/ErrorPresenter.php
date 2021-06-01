<?php declare(strict_types = 1);

namespace OriCMF\UI\Front\Error;

use Nette\Application\BadRequestException;
use Nette\Http\IResponse;
use OriCMF\UI\Front\Base\Presenter\BaseFrontPresenter;
use OriCMF\UI\Presenter\NoLogin;
use Throwable;
use function in_array;

/**
 * @property-read ErrorTemplate $template
 */
final class ErrorPresenter extends BaseFrontPresenter
{

	use NoLogin;

	private const SUPPORTED_CODES = [400, 403, 404, 410, 500];

	public function action(): void
	{
		// Note error in ajax request
		if ($this->isAjax()) {
			$this->payload->error = true;
			$this->sendPayload();
		}
	}

	public function render(Throwable|null $throwable = null): void
	{
		if ($throwable === null) {
			// Direct access, act as user error
			$code = IResponse::S404_NOT_FOUND;
			$is4xx = true;
		} elseif ($throwable instanceof BadRequestException) {
			// User error
			$code = $throwable->getCode();
			$is4xx = $code >= 400 && $code <= 499;

			if (!in_array($code, self::SUPPORTED_CODES, true)) {
				$code = $is4xx
					? 400
					: 500;
			}
		} else {
			// Real error
			$code = IResponse::S500_INTERNAL_SERVER_ERROR;
			$is4xx = false;
		}

		$view = $is4xx ? '4xx' : '5xx';

		$t = $this->translator->toFunction();

		$this->template->title = $title = $t("ori.ui.httpError.$view.title");
		$this->template->message = $t("ori.ui.httpError.$view.message");

		$this['document']->setTitle(
			$this->translator->translate($title),
		);

		$this->getHttpResponse()->setCode($code);

		$this['document-head-meta']->setRobots(['noindex']);
	}

	protected function configureCanonicalUrl(): void
	{
		// Error presenter has no canonical url
	}

}
