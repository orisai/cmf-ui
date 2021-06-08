<?php declare(strict_types = 1);

namespace OriCMF\UI\Presenter;

use Nette\Application\UI\Presenter;
use Orisai\Exceptions\Logic\InvalidArgument;
use function str_starts_with;

final class ActionLink
{

	/**
	 * @param array<string, mixed> $args
	 */
	private function __construct(private string $destination, private array $args = [])
	{
	}

	/**
	 * @param class-string<Presenter> $presenter
	 * @param array<string, mixed> $args
	 */
	public static function fromClass(string $presenter, array $args = [], string $action = 'default'): self
	{
		return new self(":$presenter:$action", $args);
	}

	/**
	 * @param array<string, mixed> $args
	 */
	public static function fromMapping(string $destination, array $args = []): self
	{
		if (
			!str_starts_with($destination, ':')
			&& !str_starts_with($destination, '//:')
		) {
			throw InvalidArgument::create()
				->withMessage(
					<<<'TXT'
Destination must be an absolute link. Relative links and "this" are forbidden.
Format: [[[module:]presenter:]action | signal!] [#fragment]
TXT,
				);
		}

		return new self($destination, $args);
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
