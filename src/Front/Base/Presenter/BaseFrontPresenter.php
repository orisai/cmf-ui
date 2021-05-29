<?php declare(strict_types = 1);

namespace OriCMF\UI\Front\Base\Presenter;

use OriCMF\UI\Front\Login\Presenter\LoginPresenter;
use OriCMF\UI\Presenter\Base\BasePresenter;

abstract class BaseFrontPresenter extends BasePresenter
{

	public const LAYOUT_PATH = __DIR__ . '/@layout.latte';

	protected function isLoginRequired(): bool
	{
		return true;
	}

	protected function checkUserIsLoggedIn(): void
	{
		if ($this->frontFirewall->isLoggedIn()) {
			return;
		}

		$expired = $this->frontFirewall->getLastExpiredLogin();
		if ($expired !== null && $expired->getLogoutReason() === $this->frontFirewall::REASON_INACTIVITY) {
			$this->flashMessage($this->translator->translate('ori.ui.login.logout.reason.inactivity'));
		}

		$this->actionRedirect(LoginPresenter::createLink(
			$this->storeRequest(),
		));
	}

	public function handleLogout(): void
	{
		$this->frontFirewall->logout();

		if (!$this->isLoginRequired()) {
			$this->redirect('this');
		} else {
			$this->actionRedirect(LoginPresenter::createLink());
		}
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
