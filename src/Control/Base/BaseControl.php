<?php declare(strict_types = 1);

namespace OriCMF\UI\Control\Base;

use Nette\Application\UI\Control;
use Nette\Application\UI\Template as PlainTemplate;
use Nette\Bridges\ApplicationLatte\Template;
use OriCMF\UI\Presenter\Base\BasePresenter;
use Orisai\Exceptions\Logic\InvalidState;
use Orisai\Exceptions\Message;
use function assert;
use function class_exists;
use function is_string;
use function is_subclass_of;
use function preg_replace;

/**
 * @method BasePresenter getPresenter()
 * @method BaseControlTemplate getTemplate()
 * @property-read BasePresenter       $presenter
 * @property-read BaseControlTemplate $template
 */
abstract class BaseControl extends Control
{

	protected function createTemplate(): Template
	{
		//TODO - $this->templateFactory
		$templateFactory = $this->getPresenter()->getTemplateFactory();

		return $templateFactory->createTemplate($this, $this->formatTemplateClass());
	}

	/**
	 * @return class-string<Template>
	 */
	public function formatTemplateClass(): string
	{
		$class = preg_replace('#Control$#', 'Template', static::class);
		assert(is_string($class));

		if ($class === static::class) {
			$class .= 'Template';
		}

		return $this->checkTemplateClass($class);
	}

	/**
	 * @return class-string<Template>
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

		if (!is_subclass_of($class, Template::class)) {
			$self = static::class;
			$templateClass = Template::class;
			$message = Message::create()
				->withContext("Trying to create template for {$self}.")
				->withProblem("Class {$class} is not subclass of {$templateClass}.")
				->withSolution('Extend required class or its descendant.');

			throw InvalidState::create()
				->withMessage($message);
		}

		return $class;
	}

	/**
	 * @deprecated Define filters in Template class instead
	 * @internal
	 */
	final public function templatePrepareFilters(PlainTemplate $template): void
	{
		parent::templatePrepareFilters($template);
	}

}
