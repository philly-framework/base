<?php
declare(strict_types=1);

namespace Elephox\DB\Abstraction\Contract;

interface DatabaseConnection
{
	public function getAdapter(): QueryAdapter;
}
