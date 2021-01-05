<?php declare(strict_types = 1);

namespace OriCMF\UI\Control\Links;

use OriCMF\UI\Control\Base\BaseControlTemplate;

final class LinksTemplate extends BaseControlTemplate
{

	/** @var array<string> */
	public array $links;

	/** @var array<array<string>> */
	public array $alternateFeeds;

	/** @var array<string> */
	public array $alternateLanguages;

}
