<?php declare(strict_types = 1);

namespace OriCMF\UI\Template\Locator;

use Nette\Application\UI\Control;
use OriCMF\UI\Template\Exception\NoTemplateFound;
use OriCMF\UI\Template\Utils\Classes;
use function array_pop;
use function explode;
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
		$classes = Classes::getClassList($control);
		$triedPaths = [];

		$parts = explode('\\', $control::class);
		$baseFileName = preg_replace('#Control$#', '', array_pop($parts));

		foreach ($classes as $class) {
			if ($class === Control::class) {
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
