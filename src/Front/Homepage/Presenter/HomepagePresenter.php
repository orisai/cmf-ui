<?php declare(strict_types = 1);

namespace OriCMF\UI\Front\Homepage\Presenter;

use OriCMF\UI\Front\Base\Presenter\BaseFrontPresenter;

/**
 * @property-read HomepageTemplate $template
 */
final class HomepagePresenter extends BaseFrontPresenter
{

	public const ACTION_DEFAULT = ':OriCMF:UI:Front:Homepage:default';

	public function actionDefault(): void
	{

	}

}
