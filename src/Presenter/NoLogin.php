<?php declare(strict_types = 1);

namespace OriCMF\UI\Presenter;

use OriCMF\UI\Presenter\Base\BasePresenter;

/**
 * @mixin BasePresenter
 */
trait NoLogin
{

	protected function checkUserIsLoggedIn(): void
	{
		// Disables login requirements
	}

}
