<?php declare(strict_types = 1);

namespace OriCMF\UI\Routing;

use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;
use Nette\Routing\Router;
use OriCMF\UI\Admin\Dashboard\Presenter\DashboardPresenter;
use OriCMF\UI\Admin\Error\Presenter\ErrorPresenter as AdminErrorPresenter;
use OriCMF\UI\Admin\Login\Presenter\LoginPresenter as AdminLoginPresenter;
use OriCMF\UI\Front\Error\Presenter\ErrorPresenter as FrontErrorPresenter;
use OriCMF\UI\Front\Homepage\Presenter\HomepagePresenter;
use OriCMF\UI\Front\Login\Presenter\LoginPresenter as FrontLoginPresenter;
use function substr;

final class CoreRouterProvider implements RouterProvider
{

	public function getRouter(): Router
	{
		$router = new RouteList();

		$router[] = new Route('/admin/login', substr(AdminLoginPresenter::ACTION_DEFAULT, 1));
		$router[] = new Route('/admin/error', substr(AdminErrorPresenter::ACTION_DEFAULT, 1));
		$router[] = new Route('/admin', substr(DashboardPresenter::ACTION_DEFAULT, 1));

		$router[] = new Route('/login', substr(FrontLoginPresenter::ACTION_DEFAULT, 1));
		$router[] = new Route('/error', substr(FrontErrorPresenter::ACTION_DEFAULT, 1));
		$router[] = new Route('/', substr(HomepagePresenter::ACTION_DEFAULT, 1));

		return $router;
	}

}
