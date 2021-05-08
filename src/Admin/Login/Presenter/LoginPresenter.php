<?php declare(strict_types = 1);

namespace OriCMF\UI\Admin\Login\Presenter;

use OriCMF\UI\Admin\Base\Presenter\BaseAdminPresenter;
use OriCMF\UI\Presenter\ActionLink;
use OriCMF\UI\Presenter\NoLogin;

/**
 * @property-read LoginTemplate $template
 */
class LoginPresenter extends BaseAdminPresenter
{

	use NoLogin;

	public const ACTION_DEFAULT = ':OriCMF:UI:Admin:Login:default';

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
		// Action method
	}

}
