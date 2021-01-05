<?php declare(strict_types = 1);

namespace OriCMF\UI\Control\Base;

use OriCMF\UI\Template\Locator\ControlTemplateLocator;
use OriCMF\UI\Template\UITemplate;

abstract class BaseControlTemplate extends UITemplate
{

	private ControlTemplateLocator $templateLocator;
	private string $view = 'default';

	public BaseControl $control;

	public function setView(string $view): void
	{
		$this->view = $view;
	}

	/**
	 * @param array<mixed> $params
	 */
	public function render(?string $file = null, array $params = []): void
	{
		parent::render($this->getFilePath($file), $params);
	}

	/**
	 * @param array<mixed> $params
	 */
	public function renderToString(?string $file = null, array $params = []): string
	{
		return parent::renderToString($this->getFilePath($file), $params);
	}

	/**
	 * @internal
	 */
	public function setTemplateLocator(ControlTemplateLocator $templateLocator): void
	{
		$this->templateLocator = $templateLocator;
	}

	private function getFilePath(?string $file): string
	{
		if ($file === null && ($file = $this->getFile()) === null) {
			return $this->templateLocator->getTemplatePath($this->control, $this->view);
		}

		return $file;
	}

}
