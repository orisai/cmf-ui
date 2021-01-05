<?php declare(strict_types = 1);

namespace OriCMF\UI\Auth;

use Orisai\Auth\Authentication\StringIdentity;

final class UserIdentity extends StringIdentity
{

	private ?self $parentIdentity;

	/**
	 * @param array<string> $roles
	 */
	public function __construct(string $id, array $roles, ?UserIdentity $parentIdentity = null)
	{
		parent::__construct($id, $roles);
		$this->parentIdentity = $parentIdentity;
	}

	/**
	 * @return UserIdentity|null
	 */
	public function getParentIdentity(): ?self
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
