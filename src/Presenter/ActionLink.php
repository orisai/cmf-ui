<?php declare(strict_types = 1);

namespace OriCMF\UI\Presenter;

use Orisai\Exceptions\Logic\InvalidArgument;
use function str_starts_with;

final class ActionLink
{

	private string $destination;

	/** @var array<mixed> */
	private array $args;

	/**
	 * @param array<string, mixed> $args
	 */
	public function __construct(string $destination, array $args = [])
	{
		if (!str_starts_with($destination, ':') && !str_starts_with($destination, '//:')) {
			throw InvalidArgument::create()
				->withMessage(
					<<<'TXT'
Destination must be absolute, relative links and "this" are forbidden.
Format: [[[module:]presenter:]action | signal!] [#fragment]
TXT,
				);
		}

		$this->destination = $destination;
		$this->args = $args;
	}

	public function getDestination(): string
	{
		return $this->destination;
	}

	/**
	 * @return array<mixed>
	 */
	public function getArguments(): array
	{
		return $this->args;
	}

}