<?php declare(strict_types = 1);

namespace OriCMF\UI\Admin\Sign\In;

use OriCMF\UI\Admin\Base\Presenter\BaseAdminPresenter;
use OriCMF\UI\Presenter\NoLogin;

/**
 * @property-read InTemplate $template
 */
final class InPresenter extends BaseAdminPresenter
{

	use NoLogin;

	private string $backlink = '';

	public function actionDefault(): void
	{
		//TODO - login
	}

}
