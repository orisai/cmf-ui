<?php declare(strict_types = 1);

namespace OriCMF\UI\Front\Sign\In;

use OriCMF\UI\Front\Base\Presenter\BaseFrontPresenter;
use OriCMF\UI\Presenter\NoLogin;

/**
 * @property-read InTemplate $template
 */
final class InPresenter extends BaseFrontPresenter
{

	use NoLogin;

	private string $backlink = '';

	public function actionDefault(): void
	{
		//TODO - login
	}

}
