<?php declare(strict_types = 1);

namespace OriCMF\UI\Control\NoScript;

use OriCMF\UI\Control\Base\BaseControl;

/**
 * @property-read NoScriptTemplate $template
 */
class NoScriptControl extends BaseControl
{

	/** @var array<string> */
	private array $noScripts = [];

	/**
	 * Add noscript <noscript>{$content|noescape}</noscript>
	 * @return $this
	 */
	public function addNoScript(string $content): self
	{
		$this->noScripts[] = $content;

		return $this;
	}

	public function render(): void
	{
		$this->template->noScripts = $this->noScripts;

		$this->template->render();
	}

}
