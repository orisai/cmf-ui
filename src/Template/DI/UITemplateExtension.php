<?php declare(strict_types = 1);

namespace OriCMF\UI\Template\DI;

use Nette\DI\CompilerExtension;
use Nette\DI\Definitions\ServiceDefinition;
use function assert;

final class UITemplateExtension extends CompilerExtension
{

	public function beforeCompile(): void
	{
		parent::beforeCompile();

		$builder = $this->getContainerBuilder();

		$templateFactoryDef = $builder->getDefinition('latte.templateFactory');
		assert($templateFactoryDef instanceof ServiceDefinition);

		$adminFirewallDef = $builder->getDefinition('ori.ui.admin.auth.firewall');
		$frontFirewallDef = $builder->getDefinition('ori.ui.front.auth.firewall');

		$controlTemplateLocatorDef = $builder->getDefinition('ori.ui.template.locator.control');

		$templateFactoryDef
			->addSetup(
				<<<'PHP'
?->onCreate[] = function(\Nette\Application\UI\Template $template): void {
	if ($template instanceof \OriCMF\UI\Template\UITemplate) {
		$template->adminFirewall = ?;
		$template->frontFirewall = ?;

		if ($template instanceof \OriCMF\UI\Control\Base\BaseControlTemplate) {
			$template->setTemplateLocator(?);
		}
	}
};
PHP,
				[
					'@self',
					$adminFirewallDef,
					$frontFirewallDef,
					$controlTemplateLocatorDef,
				],
			);
	}

}
