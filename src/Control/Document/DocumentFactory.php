<?php declare(strict_types = 1);

namespace OriCMF\UI\Control\Document;

interface DocumentFactory
{

	public function create(): DocumentControl;

}
