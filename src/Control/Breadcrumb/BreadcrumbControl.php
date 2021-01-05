<?php declare(strict_types = 1);

namespace OriCMF\UI\Control\Breadcrumb;

use OriCMF\UI\Control\Base\BaseControl;

/**
 * @property-read BreadcrumbTemplate $template
 */
class BreadcrumbControl extends BaseControl
{

	/** @var array<mixed> */
	private array $links = [];

	/** @var array<string> */
	private array $iconsMapping = [];

	/**
	 * @param array<string> $mapping
	 */
	public function addIconsMapping(array $mapping): self
	{
		$this->iconsMapping += $mapping;

		return $this;
	}

	public function addLink(string $title, ?string $uri = null, ?string $icon = null): self
	{
		$this->links[] = [
			'title' => $title,
			'uri' => $uri,
			'icon' => $this->iconsMapping[$icon] ?? $icon,
		];

		return $this;
	}

	public function render(): void
	{
		$this->template->links = $this->links;

		$this->template->render();
	}

}
