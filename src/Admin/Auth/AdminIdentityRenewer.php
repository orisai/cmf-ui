<?php declare(strict_types = 1);

namespace OriCMF\UI\Admin\Auth;

use OriCMF\Core\User\UserRepository;
use OriCMF\Core\User\UserState;
use OriCMF\UI\Auth\UserIdentity;
use Orisai\Auth\Authentication\Identity;
use Orisai\Auth\Authentication\IdentityRenewer;
use Orisai\Auth\Authorization\PrivilegeAuthorizer;
use function assert;

/**
 * @phpstan-implements IdentityRenewer<UserIdentity>
 */
final class AdminIdentityRenewer implements IdentityRenewer
{

	public function __construct(private UserRepository $userRepository, private PrivilegeAuthorizer $authorizer)
	{
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

		// User was controlled by puppeteer which is not available anymore
		if ($puppeteer !== null && $newPuppeteer === null) {
			return null;
		}

		$newIdentity = UserIdentity::fromUser($user, $newPuppeteer);

		if (!$this->authorizer->isAllowed($newIdentity, 'administration.entry')) {
			return null;
		}

		return $newIdentity;
	}

}
