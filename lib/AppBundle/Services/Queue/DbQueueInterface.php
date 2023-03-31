<?php

namespace Imported\AppBundle\Services\Queue;

interface DbQueueInterface
{
    /**
     * Add Item To Queue DB to use it again later when process the queue
     * @param string $data
     * @param string $groupName
     * @return void
     */
    public function addItemToQueue(string $data,string $groupName): void;
    /**
     * get all Queue Ids Based On group name and specify it by limit and offset
     * @param string $groupName
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getAllQueueIdsByGroup(string $groupName, int $limit = 50, int $offset = 0): array;
    /**
     * get the queue entry by queue Id
     * @param int $id
     * @return array
     */
    public function getQueueEntryById(int $id): array;

    /**
     * get the count queue items by group name
     * @param string $groupName
     * @return int
     */
    public function getQueueItemCountByGroup(string $groupName): int;
    /**
     * delete the queue item by queue id
     * @param int $id
     * @return void
     */
    public function deleteQueueItemById(int $id): void;



}
