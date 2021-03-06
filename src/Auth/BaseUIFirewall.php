<?php declare(strict_types = 1);

namespace OriCMF\UI\Auth;

use Brick\DateTime\Clock;
use OriCMF\Core\User\User;
use OriCMF\Core\User\UserRepository;
use Orisai\Auth\Authentication\BaseFirewall;
use Orisai\Auth\Authentication\Exception\NotLoggedIn;
use Orisai\Auth\Authentication\Firewall;
use Orisai\Auth\Authentication\IdentityRenewer;
use Orisai\Auth\Authentication\LoginStorage;
use Orisai\Auth\Authorization\Authorizer;
use Orisai\Auth\Authorization\PolicyManager;

/**
 * @phpstan-extends BaseFirewall<UserIdentity, Firewall>
 * @method login(UserIdentity $identity)
 * @method renewIdentity(UserIdentity $identity)
 * @method UserIdentity getIdentity()
 */
abstract class BaseUIFirewall extends BaseFirewall
{

	public function __construct(
		private UserRepository $userRepository,
		LoginStorage $storage,
		IdentityRenewer $renewer,
		Authorizer $authorizer,
		PolicyManager $policyManager,
		Clock|null $clock = null,
	)
	{
		parent::__construct($storage, $renewer, $authorizer, $policyManager, $clock);
	}

	public function getUser(): User
	{
		$identity = $this->fetchIdentity();

		if ($identity === null) {
			throw NotLoggedIn::create(static::class, __FUNCTION__);
		}

		return $this->userRepository->getByIdChecked($identity->getId());
	}

	public function getPuppeteer(): User|null
	{
		$puppeteer = $this->getIdentity()->getPuppeteer();

		if ($puppeteer === null) {
			return null;
		}

		return $this->userRepository->getByIdChecked($puppeteer->getId());
	}

}
