<?php declare(strict_types = 1);

namespace OriCMF\UI\Auth;

use OriCMF\Core\Role\RoleRepository;
use Orisai\Auth\Authorization\PrivilegeAuthorizer;

final class UserAuthorizerCreator
{

	/** @var array<string> */
	private array $privileges;

	public function __construct(private RoleRepository $roleRepository)
	{
	}

	public function create(): PrivilegeAuthorizer
	{
		$authorizer = new PrivilegeAuthorizer();

		foreach ($this->privileges as $privilege) {
			$authorizer->addPrivilege($privilege);
		}

		$roles = $this->roleRepository->findAll();

		foreach ($roles as $role) {
			$authorizer->addRole($role->name);

			foreach ($role->privileges as $privilege) {
				$authorizer->allow($role->name, $privilege);
			}
		}

		return $authorizer;
	}

	/**
	 * @param array<string> $privileges
	 */
	public function addPrivileges(array $privileges): void
	{
		$this->privileges = $privileges;
	}

}
