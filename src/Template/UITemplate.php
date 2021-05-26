<?php declare(strict_types = 1);

namespace OriCMF\UI\Template;

use Latte\Engine;
use Nette\Bridges\ApplicationLatte\Template;
use OriCMF\UI\Admin\Auth\AdminFirewall;
use OriCMF\UI\Front\Auth\FrontFirewall;

/**
 * @method bool isLinkCurrent(string $destination = null, array $args = [])
 * @method bool isModuleCurrent(string $module)
 */
abstract class UITemplate extends Template
{

	public AdminFirewall $adminFirewall;

	public FrontFirewall $frontFirewall;

	public string $baseUrl;

	/** @var array<mixed> */
	public array $flashes;

	final public function __construct(Engine $latte)
	{
		parent::__construct($latte);
	}

}
