<?php declare(strict_types = 1);

namespace OriCMF\UI\Front\Auth;

use OriCMF\Core\User\UserRepository;
use OriCMF\Core\User\UserState;
use OriCMF\UI\Auth\UserIdentity;
use Orisai\Auth\Authentication\Identity;
use Orisai\Auth\Authentication\IdentityRenewer;
use function assert;

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

	public function renewIdentity(Identity $identity): UserIdentity|null
	{
		assert($identity instanceof UserIdentity);

		$user = $this->userRepository->getBy([
			'id' => $identity->getId(),
			'state' => UserState::ACTIVE(),
		]);

		if ($user === null) {
			return null;
		}

		$puppeteer = $identity->getPuppeteer();
		$newPuppeteer = $puppeteer !== null
			? $this->renewIdentity($puppeteer)
			: null;

		return UserIdentity::fromUser($user, $newPuppeteer);
	}

}
