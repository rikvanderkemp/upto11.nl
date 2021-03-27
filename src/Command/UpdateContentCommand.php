<?php /** @noinspection PhpMissingFieldTypeInspection */

namespace App\Command;

use App\Content\ContentProcessor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Lock\LockFactory;

class UpdateContentCommand extends Command
{
    /**
     * @psalm-suppress MissingPropertyType
     * @var ?string
     */
    protected static $defaultName = 'app:update-content';

    /**
     * @psalm-suppress MissingPropertyType
     * @var string
     */
    protected static $defaultDescription = 'Update content from content directory';
    private LockFactory $lockFactory;
    private ContentProcessor $processor;

    public function __construct(LockFactory $lockFactory, ContentProcessor $processor)
    {
        parent::__construct(self::$defaultName);
        $this->lockFactory = $lockFactory;
        $this->processor = $processor;
    }


    /**
     * @return void
     * @noinspection ReturnTypeCanBeDeclaredInspection
     */
    protected function configure()
    {
        $this->setDescription(self::$defaultDescription);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $lock = $this->lockFactory->createLock('update-content');
        $lock->acquire(true);

        $this->processor->process();

        $lock->release();

        return Command::SUCCESS;
    }
}
