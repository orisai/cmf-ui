<?php declare(strict_types = 1);

namespace OriCMF\UI\Admin\Dashboard\Presenter;

use OriCMF\UI\Admin\Base\Presenter\BaseAdminPresenter;

/**
 * @property-read DashboardTemplate $template
 */
final class DashboardPresenter extends BaseAdminPresenter
{

	public const ACTION_DEFAULT = ':OriCMF:UI:Admin:Dashboard:default';

	public function actionDefault(): void
	{

	}

}
