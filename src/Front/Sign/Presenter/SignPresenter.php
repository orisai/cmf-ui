<?php declare(strict_types = 1);

namespace OriCMF\UI\Front\Sign\Presenter;

use OriCMF\UI\Front\Base\Presenter\BaseFrontPresenter;
use OriCMF\UI\Presenter\ActionLink;
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

	public static function linkIn(string $backlink = ''): ActionLink
	{
		return new ActionLink(self::ACTION_IN, [
			'backlink' => $backlink,
		]);
	}

	public function actionIn(): void
	{

	}

	public static function linkOut(): ActionLink
	{
		return new ActionLink(self::ACTION_OUT);
	}

	public function actionOut(): void
	{

	}

}
