<?php declare(strict_types = 1);

namespace OriCMF\UI\Auth;

use Orisai\Auth\Authorization\PermissionAuthorizer;

final class UserAuthorizerCreator
{

	public function create(): PermissionAuthorizer
	{
		return new PermissionAuthorizer();
	}

}
