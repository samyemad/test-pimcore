<?php

declare(strict_types=1);

namespace Imported\AppBundle\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230326210549 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Custom Queue for import data ';
    }

    public function up(Schema $schema): void
    {
        if (!$schema->hasTable('custom_importer_queue')) {
            $this->addSql('CREATE TABLE IF NOT EXISTS `custom_import_queue` (
            id bigint AUTO_INCREMENT,
            createdAt DATETIME NULL,
            `data` TEXT null,
            groupName varchar(13) NULL,
            PRIMARY KEY (id)
            )
        ');
        }
    }

    public function down(Schema $schema): void
    {
        if ($schema->hasTable('custom_importer_queue')) {
            $this->addSql('DROP TABLE IF EXISTS `custom_import_queue`;');
        }
    }
}
