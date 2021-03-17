<?php declare(strict_types = 1);

namespace OriCMF\UI\Auth;

use OriCMF\Core\Role\Role;
use OriCMF\Core\User\User;
use Orisai\Auth\Authentication\StringIdentity;
use Orisai\Exceptions\Logic\InvalidState;
use function array_map;

final class UserIdentity extends StringIdentity
{

	private ?UserIdentity $parentIdentity;

	/**
	 * @param array<string> $roles
	 */
	public function __construct(string $id, array $roles, ?UserIdentity $parentIdentity = null)
	{
		parent::__construct($id, $roles);
		$this->parentIdentity = $parentIdentity;

		if ($parentIdentity !== null && $parentIdentity->getParentIdentity() !== null) {
			throw InvalidState::create()
				->withMessage('Parent identity is not allowed to have its own parent identity.');
		}
	}

	public static function fromUser(User $user, ?UserIdentity $parentIdentity = null): self
	{
		$roles = array_map(
			static fn (Role $role): string => $role->name,
			$user->roles->getIterator()->fetchAll(),
		);

		return new self($user->id, $roles, $parentIdentity);
	}

	public function getParentIdentity(): ?UserIdentity
	{
		return $this->parentIdentity;
	}

	/**
	 * @return array<mixed>
	 */
	public function __serialize(): array
	{
		$data = parent::__serialize();
		$data['parentIdentity'] = $this->parentIdentity;

		return $data;
	}

	/**
	 * @param array<mixed> $data
	 */
	public function __unserialize(array $data): void
	{
		parent::__unserialize($data);
		$this->parentIdentity = $data['parentIdentity'];
	}

}
