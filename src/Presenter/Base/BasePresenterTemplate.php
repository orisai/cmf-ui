<?php declare(strict_types = 1);

namespace OriCMF\UI\Presenter\Base;

use OriCMF\UI\Template\UITemplate;

/**
 * @method bool isLinkCurrent(string $destination = null, array $args = [])
 * @method bool isModuleCurrent(string $module)
 */
abstract class BasePresenterTemplate extends UITemplate
{

	public BasePresenter $presenter;

}
