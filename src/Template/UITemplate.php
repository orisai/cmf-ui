<?php declare(strict_types = 1);

namespace OriCMF\UI\Template;

use Nette\Bridges\ApplicationLatte\Template;
use OriCMF\UI\Admin\Auth\AdminFirewall;
use OriCMF\UI\Front\Auth\FrontFirewall;

abstract class UITemplate extends Template
{

	public AdminFirewall $adminFirewall;
	public FrontFirewall $frontFirewall;

	public string $baseUrl;

	/** @var array<mixed> */
	public array $flashes = [];

}
