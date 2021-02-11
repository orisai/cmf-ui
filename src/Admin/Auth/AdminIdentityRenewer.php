<?php declare(strict_types = 1);

namespace OriCMF\UI\Admin\Auth;

use OriCMF\Core\User\UserRepository;
use OriCMF\UI\Auth\UserIdentity;
use Orisai\Auth\Authentication\Identity;
use Orisai\Auth\Authentication\IdentityRenewer;
use Orisai\Auth\Authorization\PermissionAuthorizer;

/**
 * @phpstan-implements IdentityRenewer<UserIdentity>
 */
final class AdminIdentityRenewer implements IdentityRenewer
{

	private UserRepository $userRepository;
	private PermissionAuthorizer $authorizer;

	public function __construct(UserRepository $userRepository, PermissionAuthorizer $authorizer)
	{
		$this->userRepository = $userRepository;
		$this->authorizer = $authorizer;
	}

	public function renewIdentity(Identity $identity): ?UserIdentity
	{
		$user = $this->userRepository->getById($identity->getId());

		if ($user === null) {
			return null;
		}

		$identity = UserIdentity::fromUser($user);

		if (!$this->authorizer->isAllowed($identity, 'administration.entry')) {
			return null;
		}

		return $identity;
	}

}
