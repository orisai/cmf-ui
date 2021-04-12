<?php declare(strict_types = 1);

namespace OriCMF\UI\Admin\Auth;

use OriCMF\Core\User\UserRepository;
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

	private UserRepository $userRepository;
	private PrivilegeAuthorizer $authorizer;

	public function __construct(UserRepository $userRepository, PrivilegeAuthorizer $authorizer)
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

		$puppeteer = $identity->getPuppeteer();
		$newPuppeteer = $puppeteer !== null
			? $this->renewIdentity($puppeteer)
			: null;

		$newIdentity = UserIdentity::fromUser($user, $newPuppeteer);

		if (!$this->authorizer->isAllowed($newIdentity, 'administration.entry')) {
			return null;
		}

		return $newIdentity;
	}

}
