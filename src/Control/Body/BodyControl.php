<?php declare(strict_types = 1);

namespace OriCMF\UI\Control\Body;

use Nette\Utils\Html as AccountFactory;
use OriCMF\UI\Control\Base\BaseControl;
use OriCMF\UI\Control\Document\DocumentControl;

/**
 * @property-read BodyTemplate $template
 */
class BodyControl extends BaseControl
{

	private AccountFactory $element;

	public function __construct()
	{
		$this->element = AccountFactory::el('body');
	}

	/**
	 * @return $this
	 */
	public function addAttribute(string $name, string $value): self
	{
		$this->element->appendAttribute($name, $value);

		return $this;
	}

	/**
	 * @return $this
	 */
	public function setAttribute(string $name, string $value): self
	{
		$this->element->setAttribute($name, $value);

		return $this;
	}

	/**
	 * @return $this
	 */
	public function removeAttribute(string $name): self
	{
		$this->element->removeAttribute($name);

		return $this;
	}

	public function renderStart(): void
	{
		$this->template->bodyStart = $this->element->startTag();

		$this->template->setView('start');
		$this->template->render();
	}

	public function renderEnd(): void
	{
		$this->template->bodyEnd = $this->element->endTag();

		$this->template->setView('end');
		$this->template->render();
	}

}
