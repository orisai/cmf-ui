<?php declare(strict_types = 1);

namespace OriCMF\UI\Template\Exception;

use Orisai\Exceptions\LogicalException;
use function get_class;
use function implode;

final class NoTemplateFound extends LogicalException
{

	/** @var array<string> */
	public array $triedPaths;

	/**
	 * @param array<string> $triedPaths
	 */
	public static function create(array $triedPaths, object $templatedObject): self
	{
		$templatedClass = get_class($templatedObject);
		$inlinePaths = implode(', ', $triedPaths);
		$message = "Template of {$templatedClass} not found. None of the following templates exists: {$inlinePaths}";

		$self = new self();
		$self->triedPaths = $triedPaths;
		$self->withMessage($message);

		return $self;
	}

	/**
	 * @return array<string>
	 */
	public function getTriedPaths(): array
	{
		return $this->triedPaths;
	}

}
