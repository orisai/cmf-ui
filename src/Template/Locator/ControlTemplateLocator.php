<?php declare(strict_types = 1);

namespace OriCMF\UI\Template\Locator;

use Nette\Application\UI\Control;
use OriCMF\UI\Template\Exception\NoTemplateFound;
use OriCMF\UI\Template\Utils\Classes;
use function is_file;

final class ControlTemplateLocator
{

	/**
	 * @throws NoTemplateFound
	 */
	public function getTemplatePath(Control $control, string $viewName): string
	{
		$classes = Classes::getClassList($control);
		$triedPaths = [];

		foreach ($classes as $class) {
			if ($class === Control::class) {
				break;
			}

			$dir = Classes::getClassDir($class);
			$templatePath = "{$dir}/templates/{$viewName}.latte";

			if (is_file($templatePath)) {
				return $templatePath;
			}

			$triedPaths[] = $templatePath;
		}

		throw NoTemplateFound::create($triedPaths, $control);
	}

}
