<?php declare(strict_types = 1);

namespace OriCMF\UI\Template\Locator;

use Nette\Application\UI\Control;
use OriCMF\UI\Control\Base\BaseControl;
use OriCMF\UI\Template\Exception\NoTemplateFound;
use Orisai\Utils\Classes;
use function is_file;
use function preg_replace;

final class ControlTemplateLocator
{

	public const DEFAULT_VIEW_NAME = 'default';

	public function __construct(private string $rootDir)
	{
	}

	/**
	 * @throws NoTemplateFound
	 */
	public function getTemplatePath(Control $control, string $viewName): string
	{
		$classes = Classes::getClassList($control::class);
		$triedPaths = [];

		$baseFileName = preg_replace('#Control$#', '', Classes::getShortName($control::class));

		foreach ($classes as $class) {
			if ($class === Control::class || $class === BaseControl::class) {
				break;
			}

			$fileName = $viewName === self::DEFAULT_VIEW_NAME
				? $baseFileName
				: "$baseFileName.$viewName";

			$dir = Classes::getClassDir($class);
			$templatePath = "$dir/$fileName.latte";

			if (is_file($templatePath)) {
				return $templatePath;
			}

			$triedPaths[] = $templatePath;
		}

		throw NoTemplateFound::create($triedPaths, $control, $this->rootDir);
	}

}
