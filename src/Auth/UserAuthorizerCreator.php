<?php declare(strict_types = 1);

namespace OriCMF\UI\Auth;

use OriCMF\Core\Role\RoleRepository;
use Orisai\Auth\Authorization\PermissionAuthorizer;

final class UserAuthorizerCreator
{

	private RoleRepository $roleRepository;

	/** @var array<string> */
	private array $privileges;

	public function __construct(RoleRepository $roleRepository)
	{
		$this->roleRepository = $roleRepository;
	}

	public function create(): PermissionAuthorizer
	{
		$authorizer = new PermissionAuthorizer();

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
