<?php declare(strict_types = 1);

namespace OriCMF\UI\Admin\Auth;

use OriCMF\Core\User\UserRepository;
use OriCMF\UI\Auth\UserIdentity;
use Orisai\Auth\Authentication\Identity;
use Orisai\Auth\Authentication\IdentityRenewer;
use Orisai\Auth\Authorization\PermissionAuthorizer;
use function assert;

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
		assert($identity instanceof UserIdentity);

		$user = $this->userRepository->getById($identity->getId());

		if ($user === null) {
			return null;
		}

		$parentIdentity = $identity->getParentIdentity();
		$newParentIdentity = $parentIdentity !== null
			? $this->renewIdentity($parentIdentity)
			: null;

		$newIdentity = UserIdentity::fromUser($user, $newParentIdentity);

		if (!$this->authorizer->isAllowed($newIdentity, 'administration.entry')) {
			return null;
		}

		return $newIdentity;
	}

}
