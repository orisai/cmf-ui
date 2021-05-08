<?php declare(strict_types = 1);

namespace OriCMF\UI\Control\Head;

use OriCMF\UI\Control\Base\BaseControl;
use OriCMF\UI\Control\Icons\IconsControl;
use OriCMF\UI\Control\Icons\IconsFactory;
use OriCMF\UI\Control\Links\LinksControl;
use OriCMF\UI\Control\Links\LinksFactory;
use OriCMF\UI\Control\Meta\MetaControl;
use OriCMF\UI\Control\Meta\MetaFactory;
use OriCMF\UI\Control\NoScript\NoScriptControl;
use OriCMF\UI\Control\NoScript\NoScriptFactory;
use OriCMF\UI\Control\Styles\StylesControl;
use OriCMF\UI\Control\Styles\StylesFactory;
use OriCMF\UI\Control\Title\TitleControl;
use OriCMF\UI\Control\Title\TitleFactory;

/**
 * @property-read HeadTemplate $template
 */
class HeadControl extends BaseControl
{

	private IconsFactory $iconsFactory;

	private LinksFactory $linksFactory;

	private MetaFactory $metaFactory;

	private NoScriptFactory $noScriptFactory;

	private TitleFactory $titleFactory;

	private StylesFactory $stylesFactory;

	public function __construct(
		IconsFactory $iconsFactory,
		LinksFactory $linksFactory,
		MetaFactory $metaFactory,
		NoScriptFactory $noScriptFactory,
		TitleFactory $titleFactory,
		StylesFactory $stylesFactory,
	)
	{
		$this->iconsFactory = $iconsFactory;
		$this->linksFactory = $linksFactory;
		$this->metaFactory = $metaFactory;
		$this->noScriptFactory = $noScriptFactory;
		$this->titleFactory = $titleFactory;
		$this->stylesFactory = $stylesFactory;
	}

	public function render(): void
	{
		$this->template->render();
	}

	protected function createComponentIcons(): IconsControl
	{
		return $this->iconsFactory->create();
	}

	protected function createComponentLinks(): LinksControl
	{
		return $this->linksFactory->create();
	}

	protected function createComponentMeta(): MetaControl
	{
		return $this->metaFactory->create();
	}

	protected function createComponentNoScript(): NoScriptControl
	{
		return $this->noScriptFactory->create();
	}

	protected function createComponentTitle(): TitleControl
	{
		return $this->titleFactory->create();
	}

	protected function createComponentStyles(): StylesControl
	{
		return $this->stylesFactory->create();
	}

}
