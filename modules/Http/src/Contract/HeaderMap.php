<?php
declare(strict_types=1);

namespace Elephox\Http\Contract;

use Elephox\Collection\Contract\GenericMap;

/**
 * @extends GenericMap<string, list<string>>
 */
interface HeaderMap extends GenericMap
{
}
