<?php declare(strict_types = 1);

namespace OriCMF\UI\Admin\Sign\Presenter;

use OriCMF\UI\Admin\Base\Presenter\BaseAdminPresenter;
use OriCMF\UI\Presenter\NoLogin;

/**
 * @property-read SignTemplate $template
 */
class SignPresenter extends BaseAdminPresenter
{

	use NoLogin;

	public const ACTION_IN = ':OriCMF:UI:Admin:Sign:in';
	public const ACTION_OUT = ':OriCMF:UI:Admin:Sign:out';

	/** @persistent */
	public string $backlink = '';

	public function actionIn(): void
	{

	}

	public function actionOut(): void
	{

	}

}
