<?php declare(strict_types = 1);

namespace OriCMF\UI\Front\Login\Presenter;

use OriCMF\UI\Front\Base\Presenter\BaseFrontPresenter;
use OriCMF\UI\Presenter\ActionLink;
use OriCMF\UI\Presenter\NoLogin;

/**
 * @property-read LoginTemplate $template
 */
class LoginPresenter extends BaseFrontPresenter
{

	use NoLogin;

	public const ACTION_DEFAULT = ':OriCMF:UI:Front:Login:default';

	/** @persistent */
	public string $backlink = '';

	public static function linkDefault(string $backlink = ''): ActionLink
	{
		return new ActionLink(self::ACTION_DEFAULT, [
			'backlink' => $backlink,
		]);
	}

	public function actionDefault(): void
	{

	}

}