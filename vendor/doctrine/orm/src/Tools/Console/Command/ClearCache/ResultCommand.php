<?php

declare(strict_types=1);

namespace Doctrine\ORM\Tools\Console\Command\ClearCache;

use Doctrine\Common\Cache\ApcCache;
use Doctrine\Common\Cache\ClearableCache;
use Doctrine\Common\Cache\FlushableCache;
use Doctrine\Common\Cache\XcacheCache;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\Tools\Console\Command\AbstractEntityManagerCommand;
use Doctrine\ORM\Tools\Console\CommandCompatibility;
use InvalidArgumentException;
use LogicException;
use Symfony\Component\Cache\Adapter\ApcuAdapter;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use function get_debug_type;
use function method_exists;
use function sprintf;

/**
 * Command to clear the result cache of the various cache drivers.
 *
 * @link    www.doctrine-project.org
 */
class ResultCommand extends AbstractEntityManagerCommand
{
    use CommandCompatibility;

    /** @return void */
    protected function configure()
    {
        $this->setName('orm:clear-cache:result')
             ->setDescription('Clear all result cache of the various cache drivers')
             ->addOption('em', null, InputOption::VALUE_REQUIRED, 'Name of the entity manager to operate on')
             ->addOption('flush', null, InputOption::VALUE_NONE, 'If defined, cache entries will be flushed instead of deleted/invalidated.')
             ->setHelp(<<<'EOT'
The <info>%command.name%</info> command is meant to clear the result cache of associated Entity Manager.
It is possible to invalidate all cache entries at once - called delete -, or flushes the cache provider
instance completely.

The execution type differ on how you execute the command.
If you want to invalidate the entries (and not delete from cache instance), this command would do the work:

<info>%command.name%</info>

Alternatively, if you want to flush the cache provider using this command:

<info>%command.name% --flush</info>

Finally, be aware that if <info>--flush</info> option is passed, not all cache providers are able to flush entries,
because of a limitation of its execution nature.
EOT
             );
    }

    private function doExecute(InputInterface $input, OutputInterface $output): int
    {
        $ui = (new SymfonyStyle($input, $output))->getErrorStyle();

        $em    = $this->getEntityManager($input);
        $cache = $em->getConfiguration()->getResultCache();
        // @phpstan-ignore method.deprecated
        $cacheDriver = method_exists(Configuration::class, 'getResultCacheImpl') ? $em->getConfiguration()->getResultCacheImpl() : null;

        if (! $cacheDriver && ! $cache) {
            throw new InvalidArgumentException('No Result cache driver is configured on given EntityManager.');
        }

        if ($cacheDriver instanceof ApcCache || $cache instanceof ApcuAdapter) {
            throw new LogicException('Cannot clear APCu Cache from Console, it\'s shared in the Webserver memory and not accessible from the CLI.');
        }

        if ($cacheDriver instanceof XcacheCache) {
            throw new LogicException('Cannot clear XCache Cache from Console, it\'s shared in the Webserver memory and not accessible from the CLI.');
        }

        if (! $cache && ! ($cacheDriver instanceof ClearableCache)) {
            throw new LogicException(sprintf(
                'Can only clear cache when ClearableCache interface is implemented, %s does not implement.',
                get_debug_type($cacheDriver)
            ));
        }

        $ui->comment('Clearing <info>all</info> Result cache entries');

        $result  = $cache ? $cache->clear() : $cacheDriver->deleteAll();
        $message = $result ? 'Successfully deleted cache entries.' : 'No cache entries were deleted.';

        if ($input->getOption('flush') === true && ! $cache) {
            if (! ($cacheDriver instanceof FlushableCache)) {
                throw new LogicException(sprintf(
                    'Can only clear cache when FlushableCache interface is implemented, %s does not implement.',
                    get_debug_type($cacheDriver)
                ));
            }

            $result  = $cacheDriver->flushAll();
            $message = $result ? 'Successfully flushed cache entries.' : $message;
        }

        $ui->success($message);

        return 0;
    }
}
