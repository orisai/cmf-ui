<?php declare(strict_types = 1);

namespace OriCMF\UI\Control\Document;

use Nette\Utils\Html;
use OriCMF\UI\Control\Base\BaseControl;
use OriCMF\UI\Control\Body\BodyControl;
use OriCMF\UI\Control\Body\BodyFactory;
use OriCMF\UI\Control\Head\HeadControl;
use OriCMF\UI\Control\Head\HeadFactory;

/**
 * @property-read DocumentTemplate $template
 */
class DocumentControl extends BaseControl
{

	private Html $element;

	private HeadFactory $headFactory;

	private BodyFactory $bodyFactory;

	public function __construct(HeadFactory $headFactory, BodyFactory $bodyFactory)
	{
		$this->headFactory = $headFactory;
		$this->bodyFactory = $bodyFactory;
		$this->element = Html::el('html');
	}

	public function addAttribute(string $name, string $value): self
	{
		$this->element->appendAttribute($name, $value);

		return $this;
	}

	public function setAttribute(string $name, string $value): self
	{
		$this->element->setAttribute($name, $value);

		return $this;
	}

	public function renderStart(): void
	{
		$this->template->documentStart = $this->element->startTag();

		$this->template->setView('start');
		$this->template->render();
	}

	public function renderEnd(): void
	{
		$this->template->documentEnd = $this->element->endTag();

		$this->template->setView('end');
		$this->template->render();
	}

	protected function createComponentHead(): HeadControl
	{
		return $this->headFactory->create();
	}

	protected function createComponentBody(): BodyControl
	{
		return $this->bodyFactory->create();
	}

}