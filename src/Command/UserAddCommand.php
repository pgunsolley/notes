<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleInputOption;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

/**
 * UserAdd command.
 */
class UserAddCommand extends Command
{
    protected ?string $defaultTable = 'Users';

    /**
     * The name of this command.
     *
     * @var string
     */
    protected string $name = 'user_add';

    /**
     * Get the default command name.
     *
     * @return string
     */
    public static function defaultName(): string
    {
        return 'user_add';
    }

    /**
     * Get the command description.
     *
     * @return string
     */
    public static function getDescription(): string
    {
        return 'Add a user';
    }

    /**
     * Hook method for defining this command's option parser.
     *
     * @see https://book.cakephp.org/5/en/console-commands/commands.html#defining-arguments-and-options
     * @param \Cake\Console\ConsoleOptionParser $parser The parser to be defined
     * @return \Cake\Console\ConsoleOptionParser The built parser.
     */
    public function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        return parent::buildOptionParser($parser)
            ->setDescription(static::getDescription())
            ->addOptions([
                new ConsoleInputOption(
                    name: 'email',
                    short: 'e',
                    help: 'The user email',
                    required: true,
                ),
                new ConsoleInputOption(
                    name: 'password',
                    short: 'p',
                    help: 'The user password',
                    required: true,
                ),
            ]);
    }

    /**
     * Implement this method with your command's logic.
     *
     * @param \Cake\Console\Arguments $args The command arguments.
     * @param \Cake\Console\ConsoleIo $io The console io
     * @return int|null|void The exit code or null for success
     */
    public function execute(Arguments $args, ConsoleIo $io)
    {
        $data = [
            'email' => $args->getOption('email'),
            'password' => $args->getOption('password'),
        ];

        $table = $this->fetchTable();
        $entity = $table->newEntity($data);

        if ($entity->hasErrors()) {
            foreach ($entity->getErrors() as $field => $messages) {
                $io->warning(__('Field: {0}', $field));
                foreach ($messages as $message) {
                    $io->out($message);
                }
            }
            return static::CODE_ERROR;
        }

        if ($table->save($entity)) {
            $io->success('New user created');
            return static::CODE_SUCCESS;
        }

        $io->error('Something went wrong when saving to database');
        return static::CODE_ERROR;
    }
}
