<?php declare(strict_types = 1);

namespace OriCMF\UI\Routing;

use Nette\Application\Routers\RouteList;
use Nette\Routing\Router;
use OriCMF\UI\Admin\Dashboard\DashboardPresenter;
use OriCMF\UI\Admin\Error\ErrorPresenter as AdminErrorPresenter;
use OriCMF\UI\Admin\Login\LoginPresenter as AdminLoginPresenter;
use OriCMF\UI\Front\Error\ErrorPresenter as FrontErrorPresenter;
use OriCMF\UI\Front\Homepage\HomepagePresenter;
use OriCMF\UI\Front\Login\LoginPresenter as FrontLoginPresenter;

final class CmfUIRouterProvider implements RouterProvider
{

	public function getRouter(): Router
	{
		$router = new RouteList();

		$router->add(new SimplifiedRoute('/admin/login', AdminLoginPresenter::ACTION_DEFAULT));
		$router->add(new SimplifiedRoute('/admin/error', AdminErrorPresenter::ACTION_DEFAULT));
		$router->add(new SimplifiedRoute('/admin', DashboardPresenter::ACTION_DEFAULT));

		$router->add(new SimplifiedRoute('/login', FrontLoginPresenter::ACTION_DEFAULT));
		$router->add(new SimplifiedRoute('/error', FrontErrorPresenter::ACTION_DEFAULT));
		$router->add(new SimplifiedRoute('/', HomepagePresenter::ACTION_DEFAULT));

		return $router;
	}

}
