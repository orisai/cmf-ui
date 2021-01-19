<?php declare(strict_types = 1);

namespace OriCMF\UI\Form;

use Nette\Application\UI\Form as NetteForm;
use Nette\Localization\Translator;
use Orisai\Exceptions\Logic\Deprecated;

class Form extends NetteForm
{

	/**
	 * @deprecated Translate values passed into form directly instead
	 * @internal
	 */
	public function setTranslator(?Translator $translator = null): self
	{
		throw Deprecated::create()
			->withMessage('Do not use form built-in translator, translate values passed into form directly.');
	}

}