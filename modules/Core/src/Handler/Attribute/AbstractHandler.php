<?php
declare(strict_types=1);

namespace Elephox\Core\Handler\Attribute;

use Elephox\Core\Context\Contract\Context;
use Elephox\Core\Handler\ActionType;

abstract class AbstractHandler
{
	public function __construct(
		private ActionType $type,
	)
	{
	}

	final public function getType(): ActionType
	{
		return $this->type;
	}

	abstract public function handles(Context $context): bool;

	abstract public function invoke(object $handler, string $method, Context $context): void;
}
