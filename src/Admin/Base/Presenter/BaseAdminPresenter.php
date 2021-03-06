<?php declare(strict_types = 1);

namespace OriCMF\UI\Admin\Base\Presenter;

use OriCMF\UI\Admin\Login\Presenter\LoginPresenter;
use OriCMF\UI\Presenter\Base\BasePresenter;

abstract class BaseAdminPresenter extends BasePresenter
{

	public const LAYOUT_PATH = __DIR__ . '/templates/@layout.latte';

	protected function isLoginRequired(): bool
	{
		return true;
	}

	protected function checkUserIsLoggedIn(): void
	{
		if ($this->adminFirewall->isLoggedIn()) {
			return;
		}

		$expired = $this->adminFirewall->getExpiredLogins()[0] ?? null;
		if ($expired !== null && $expired->getLogoutReason() === $this->adminFirewall::REASON_INACTIVITY) {
			$this->flashMessage($this->translator->translate('ori.ui.login.logout.reason.inactivity'));
		}

		$this->actionRedirect(LoginPresenter::linkDefault(
			$this->storeRequest(),
		));
	}

	public function handleLogout(): void
	{
		$this->adminFirewall->logout();

		if (!$this->isLoginRequired()) {
			$this->redirect('this');
		} else {
			$this->actionRedirect(LoginPresenter::linkDefault());
		}
	}

	protected function beforeRender(): void
	{
		parent::beforeRender();

		$this['document-head-meta']->setRobots(['noindex', 'nofollow']);
		$this['document-head-title']->setModule($this->translator->translate('ori.ui.admin.title'));
	}

}
