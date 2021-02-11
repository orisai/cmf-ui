<?php declare(strict_types = 1);

namespace OriCMF\UI\Front\Auth;

use OriCMF\Core\User\UserRepository;
use OriCMF\UI\Auth\UserIdentity;
use Orisai\Auth\Authentication\Identity;
use Orisai\Auth\Authentication\IdentityRenewer;

/**
 * @phpstan-implements IdentityRenewer<UserIdentity>
 */
final class FrontIdentityRenewer implements IdentityRenewer
{

	private UserRepository $userRepository;

	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	public function renewIdentity(Identity $identity): ?UserIdentity
	{
		$user = $this->userRepository->getById($identity->getId());

		if ($user === null) {
			return null;
		}

		return UserIdentity::fromUser($user);
	}

}
