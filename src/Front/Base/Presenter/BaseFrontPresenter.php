<?php declare(strict_types = 1);

namespace OriCMF\UI\Front\Base\Presenter;

use OriCMF\UI\Presenter\Base\BasePresenter;

abstract class BaseFrontPresenter extends BasePresenter
{

	public const LAYOUT_PATH = __DIR__ . '/templates/@layout.latte';

	protected function checkUserIsLoggedIn(): void
	{
		if ($this->frontFirewall->isLoggedIn()) {
			return;
		}

		$expired = $this->frontFirewall->getExpiredLogins()[0] ?? null;
		if ($expired !== null && $expired->getLogoutReason() === $this->frontFirewall::REASON_INACTIVITY) {
			$this->flashMessage($this->translator->translate('ori.login.logout.reason.inactivity'));
		}

		$this->redirect('OriCMF:UI:Front:Sign:in', [
			'backlink' => $this->storeRequest(),
		]);
	}

	protected function beforeRender(): void
	{
		parent::beforeRender();

		if ($this->applicationConfig->getBuildConfig()->isStable()) {
			$this['document-head-meta']->setRobots(['index', 'follow']);
		} else {
			$this->getHttpResponse()->addHeader('X-Robots-Tag', 'none');
			$this['document-head-meta']->setRobots(['nofollow', 'noindex']);
		}
	}

}
