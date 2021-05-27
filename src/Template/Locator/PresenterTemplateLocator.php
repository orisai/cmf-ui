<?php declare(strict_types = 1);

namespace OriCMF\UI\Template\Locator;

use Nette\Application\UI\Presenter;
use OriCMF\UI\Template\Exception\NoTemplateFound;
use OriCMF\UI\Template\Utils\Classes;
use function is_file;

final class PresenterTemplateLocator
{

	public function __construct(private string $rootDir)
	{
	}

	/**
	 * @throws NoTemplateFound
	 */
	public function getLayoutTemplatePath(Presenter $presenter, string $layoutName): string
	{
		return $this->getPath($presenter, "@{$layoutName}");
	}

	/**
	 * @throws NoTemplateFound
	 */
	public function getActionTemplatePath(Presenter $presenter, string $viewName): string
	{
		return $this->getPath($presenter, $viewName);
	}

	/**
	 * @throws NoTemplateFound
	 */
	private function getPath(Presenter $presenter, string $viewName): string
	{
		$classes = Classes::getClassList($presenter);
		$triedPaths = [];

		foreach ($classes as $class) {
			if ($class === Presenter::class) {
				break;
			}

			$dir = Classes::getClassDir($class);

			$templatePath = "{$dir}/templates/{$viewName}.latte";

			if (is_file($templatePath)) {
				return $templatePath;
			}

			$triedPaths[] = $templatePath;
		}

		throw NoTemplateFound::create($triedPaths, $presenter, $this->rootDir);
	}

}
