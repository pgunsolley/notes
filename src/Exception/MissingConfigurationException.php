<?php
declare(strict_types=1);

namespace App\Exception;

use Cake\Http\Exception\InternalErrorException;

class MissingConfigurationException extends InternalErrorException
{
    protected string $_messageTemplate = 'The required configuration for key %s is missing';
}