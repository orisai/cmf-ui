<?php declare(strict_types = 1);

namespace OriCMF\UI\Presenter\Base;

use Nette\Application\AbortException;
use Nette\Application\BadRequestException;
use Nette\Application\Responses\TextResponse;
use Nette\Application\UI\Presenter;
use Nette\Application\UI\Template;
use Nette\Bridges\ApplicationLatte\TemplateFactory;
use Nette\FileNotFoundException;
use OriCMF\Core\Config\ApplicationConfig;
use OriCMF\UI\Admin\Auth\AdminFirewall;
use OriCMF\UI\Control\Document\DocumentControl;
use OriCMF\UI\Control\Document\DocumentFactory;
use OriCMF\UI\Front\Auth\FrontFirewall;
use OriCMF\UI\Presenter\ActionLink;
use OriCMF\UI\Template\Exception\NoTemplateFound;
use OriCMF\UI\Template\Locator\PresenterTemplateLocator;
use Orisai\Exceptions\Logic\InvalidState;
use Orisai\Exceptions\Logic\NotImplemented;
use Orisai\Exceptions\Message;
use Orisai\Localization\Translator;
use function assert;
use function class_exists;
use function implode;
use function is_string;
use function is_subclass_of;
use function preg_match;
use function preg_replace;
use function sprintf;

/**
 * @method self getPresenter()
 * @method TemplateFactory getTemplateFactory()
 * @method BasePresenterTemplate getTemplate()
 * @property-read BasePresenter         $presenter
 * @property-read BasePresenterTemplate $template
 * @property-read null                  $user
 */
abstract class BasePresenter extends Presenter
{

	public const LAYOUT_PATH = __DIR__ . '/templates/@layout.latte';

	protected AdminFirewall $adminFirewall;
	protected FrontFirewall $frontFirewall;

	private DocumentFactory $documentFactory;

	protected Translator $translator;

	protected ApplicationConfig $applicationConfig;

	private PresenterTemplateLocator $templateLocator;

	public function injectBase(
		AdminFirewall $adminFirewall,
		FrontFirewall $frontFirewall,
		DocumentFactory $documentFactory,
		Translator $translator,
		ApplicationConfig $applicationConfig,
		PresenterTemplateLocator $templateLocator
	): void
	{
		$this->adminFirewall = $adminFirewall;
		$this->frontFirewall = $frontFirewall;
		$this->documentFactory = $documentFactory;
		$this->translator = $translator;
		$this->applicationConfig = $applicationConfig;
		$this->templateLocator = $templateLocator;
	}

	final protected function startup(): void
	{
		parent::startup();

		if ($this->isLoginRequired()) {
			$this->checkUserIsLoggedIn();
		}
	}

	abstract protected function checkUserIsLoggedIn(): void;

	abstract protected function isLoginRequired(): bool;

	protected function beforeRender(): void
	{
		parent::beforeRender();

		$this['document']->addAttribute('class', 'no-js');
		$this['document']->setAttribute('lang', $this->translator->getCurrentLocale()->getTag());
		$this['document']['head']['meta']->addOpenGraph('type', 'website');

		$siteName = $this->applicationConfig->getName();
		if ($siteName !== null) {
			$this['document']->setSiteName($siteName);
		}

		$this->configureCanonicalUrl();
	}

	protected function configureCanonicalUrl(): void
	{
		$this['document']->setCanonicalUrl(
			$this->link('//this', ['backlink' => null]),
		);
	}

	protected function createComponentDocument(): DocumentControl
	{
		return $this->documentFactory->create();
	}

	/**
	 * @return never-returns
	 */
	protected function actionRedirect(ActionLink $link): void
	{
		$this->redirect($link->getDestination(), $link->getArguments());
	}

	/**
	 * @return array<string>
	 * @throws NotImplemented
	 * @internal
	 */
	public function formatLayoutTemplateFiles(): array
	{
		throw NotImplemented::create()
			->withMessage(sprintf(
				'Implementation of \'%s\' is in findLayoutTemplateFiles(), do not call method directly',
				__METHOD__,
			));
	}

	/**
	 * @internal
	 */
	final public function findLayoutTemplateFile(): ?string
	{
		$layout = $this->getLayout();

		if ($layout === false) {
			return null;
		}

		if (is_string($layout) && preg_match('#/|\\\\#', $layout) === 1) {
			return $layout;
		}

		if ($layout === true || $layout === null) {
			$layout = 'layout';
		}

		try {
			return $this->templateLocator->getLayoutTemplatePath($this, $layout);
		} catch (NoTemplateFound $exception) {
			$inlinePaths = implode('\', \'', $exception->getTriedPaths());

			throw new FileNotFoundException(
				"Layout not found. None of the following templates exists: {$inlinePaths}",
				0,
				$exception,
			);
		}
	}

	/**
	 * @return array<string>
	 * @throws NotImplemented
	 * @internal
	 */
	final public function formatTemplateFiles(): array
	{
		throw NotImplemented::create()
			->withMessage(sprintf(
				'Implementation of \'%s\' is in sendTemplates(), do not call method directly',
				__METHOD__,
			));
	}

	/**
	 * @throws BadRequestException
	 * @throws AbortException
	 */
	final public function sendTemplate(?Template $template = null): void
	{
		$template ??= $this->getTemplate();

		if ($template->getFile() === null) {
			try {
				$file = $this->templateLocator->getActionTemplatePath($this, $this->getView());
			} catch (NoTemplateFound $exception) {
				$inlinePaths = implode('\', \'', $exception->getTriedPaths());

				throw new BadRequestException(
					"Page not found. None of the following templates exists: {$inlinePaths}",
					0,
					$exception,
				);
			}

			$template->setFile($file);
		}

		$this->sendResponse(new TextResponse($template));
	}

	protected function createTemplate(): BasePresenterTemplate
	{
		$templateFactory = $this->getTemplateFactory();
		$template = $templateFactory->createTemplate($this, $this->formatTemplateClass());
		assert($template instanceof BasePresenterTemplate);

		return $template;
	}

	/**
	 * @return class-string<BasePresenterTemplate>
	 */
	public function formatTemplateClass(): string
	{
		$class = preg_replace('#Presenter$#', 'Template', static::class);
		assert(is_string($class));

		if ($class === static::class) {
			$class .= 'Template';
		}

		return $this->checkTemplateClass($class);
	}

	/**
	 * @return class-string<BasePresenterTemplate>
	 */
	protected function checkTemplateClass(string $class): string
	{
		if (!class_exists($class)) {
			$self = static::class;
			$message = Message::create()
				->withContext("Trying to create template for {$self}.")
				->withProblem("Class {$class} is required.")
				->withSolution('Create the required class and ensure it is autoloadable.');

			throw InvalidState::create()
				->withMessage($message);
		}

		$templateClass = BasePresenterTemplate::class;
		if (!is_subclass_of($class, $templateClass)) {
			$self = static::class;
			$message = Message::create()
				->withContext("Trying to create template for {$self}.")
				->withProblem("Class {$class} is not subclass of {$templateClass}.")
				->withSolution('Extend required class or its descendant.');

			throw InvalidState::create()
				->withMessage($message);
		}

		return $class;
	}

}
