<?php declare(strict_types = 1);

namespace OriCMF\UI\Template\DI;

use Latte\Engine;
use Nette\Application\UI\Template;
use Nette\Bridges\ApplicationLatte\LatteFactory;
use Nette\Bridges\ApplicationLatte\TemplateFactory;
use Nette\DI\CompilerExtension;
use Nette\DI\Container;
use Nette\DI\Definitions\FactoryDefinition;
use Nette\DI\Definitions\ServiceDefinition;
use OriCMF\UI\Admin\Auth\AdminFirewall;
use OriCMF\UI\Control\Base\BaseControlTemplate;
use OriCMF\UI\Front\Auth\FrontFirewall;
use OriCMF\UI\Template\Locator\ControlTemplateLocator;
use OriCMF\UI\Template\UIMacros;
use OriCMF\UI\Template\UITemplate;
use function assert;

final class UITemplateExtension extends CompilerExtension
{

	public function beforeCompile(): void
	{
		parent::beforeCompile();

		$builder = $this->getContainerBuilder();

		$templateFactoryDefinition = $builder->getDefinition('latte.templateFactory');
		assert($templateFactoryDefinition instanceof ServiceDefinition);

		$templateFactoryDefinition->addSetup(
			[self::class, 'prepareTemplate'],
			[$templateFactoryDefinition, '@' . Container::class],
		);

		$latteFactoryDefinition = $builder->getDefinitionByType(LatteFactory::class);
		assert($latteFactoryDefinition instanceof FactoryDefinition);

		$latteFactoryDefinition->getResultDefinition()
			->addSetup(
				[self::class, 'installMacros'],
				['@self'],
			);
	}

	public static function prepareTemplate(TemplateFactory $templateFactory, Container $container): void
	{
		$templateFactory->onCreate[] = static function (Template $template) use ($container): void {
			if ($template instanceof UITemplate) {
				$adminFirewall = $container->getByName('ori.ui.admin.auth.firewall');
				assert($adminFirewall instanceof AdminFirewall);

				$frontFirewall = $container->getByName('ori.ui.front.auth.firewall');
				assert($frontFirewall instanceof FrontFirewall);

				$template->adminFirewall = $adminFirewall;
				$template->frontFirewall = $frontFirewall;

				if ($template instanceof BaseControlTemplate) {
					$controlTemplateLocator = $container->getByName('ori.ui.template.locator.control');
					assert($controlTemplateLocator instanceof ControlTemplateLocator);
					$template->setTemplateLocator($controlTemplateLocator);
				}
			}
		};
	}

	public static function installMacros(Engine $engine): void
	{
		$engine->onCompile[] = static function (Engine $engine): void {
			UIMacros::install($engine->getCompiler());
		};
	}

}
