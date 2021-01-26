<?php declare(strict_types = 1);

namespace OriCMF\UI\Front\Sign\Presenter;

use OriCMF\UI\Front\Base\Presenter\BaseFrontPresenter;
use OriCMF\UI\Presenter\NoLogin;

/**
 * @property-read SignTemplate $template
 */
class SignPresenter extends BaseFrontPresenter
{

	use NoLogin;

	public const ACTION_IN = ':OriCMF:UI:Front:Sign:in';
	public const ACTION_OUT = ':OriCMF:UI:Front:Sign:out';

	/** @persistent */
	public string $backlink = '';

	public function actionIn(): void
	{

	}

	public function actionOut(): void
	{

	}

}
