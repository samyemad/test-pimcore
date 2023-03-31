<?php


namespace Imported\AppBundle\Services\Queue;

use Carbon\Carbon;
use Pimcore\Db;
use Psr\Log\LoggerInterface;
use Doctrine\DBAL\Exception as DoctrineException;
use Pimcore\Db\ConnectionInterface;

class DefaultDbQueue implements DbQueueInterface
{
    const QUEUE_TABLE_NAME = 'custom_import_queue';

    protected LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return ConnectionInterface
     */
    protected function getDb(): ConnectionInterface
    {
        return Db::get();
    }

    public function addItemToQueue(string $data,string $groupName): void
    {
        $carbonNow = Carbon::now();
        $db = $this->getDb();
        try {
            $db->executeQuery(sprintf(
                'INSERT INTO %s (%s) VALUES (%s)',
                self::QUEUE_TABLE_NAME,
                implode(',', ['createdAt', 'data','groupName']),
                implode(',', [
                  $db->quote($carbonNow->format('Y-m-d H:i:s')),
                    $db->quote($data),
                    $db->quote($groupName)
                ])
            ));
        } catch (DoctrineException $exception) {
            $this->logger->error($exception->getMessage());
        }
    }

    public function getAllQueueIdsByGroup(string $groupName, int $limit = 50, int $offset = 0): array
    {
        $results=[];
        try {
            $db = $this->getDb();

                $results = $this->getDb()->fetchFirstColumn(
                    sprintf('SELECT id FROM %s WHERE groupName = ? LIMIT %s OFFSET %s', self::QUEUE_TABLE_NAME,$limit,$offset),
                    [$groupName]
                );

        } catch (DoctrineException $exception) {
            $this->logger->error($exception->getMessage());
        }
        return $results;
    }

    public function getQueueEntryById(int $id): array
    {

        try {
            $result = $this->getDb()->fetchAssociative(
                sprintf('SELECT * FROM %s WHERE id = ?', self::QUEUE_TABLE_NAME),
                [$id]
            );
            return is_array($result) ? $result : [];
        } catch (DoctrineException $exception) {
            $this->logger->error($exception->getMessage());
            return [];
        }
    }

    public function getQueueItemCountByGroup(string $groupName): int
    {
        try {
            return $this->getDb()->fetchOne(
                sprintf('SELECT count(*) as count FROM %s WHERE groupName = ?', self::QUEUE_TABLE_NAME),
                [$groupName]
            ) ?? 0;

        } catch (DoctrineException $exception) {
            $this->logger->error($exception->getMessage());
            return 0;
        }

    }

    public function deleteQueueItemById(int $id): void
    {
        try {
            $this->getDb()->executeQuery(
                sprintf('DELETE FROM %s WHERE id = ?', self::QUEUE_TABLE_NAME),
                [$id]
            );
        } catch (DoctrineException $exception) {
            $this->logger->error($exception->getMessage());
        }
    }
}
