<?php

declare(strict_types=1);

/*
 * Card Element for Contao Open Source CMS.
 *
 * @copyright  Copyright (c) 2022, Erdmann & Freunde
 * @author     Erdmann & Freunde <https://erdmann-freunde.de>
 * @license    MIT
 * @link       http://github.com/nutshell-framework/card-element
 */

namespace Nutshell\CardElement\Migration;

use Contao\CoreBundle\Migration\AbstractMigration;
use Contao\CoreBundle\Migration\MigrationResult;
use Doctrine\DBAL\Connection;

class LinkMigration extends AbstractMigration
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function shouldRun(): bool
    {
        $schemaManager = $this->connection->createSchemaManager();

        $columns = $schemaManager->listTableColumns('tl_content');

        return
            isset($columns['url']) &&
            !isset($columns['cardurl']) &&
            !isset($columns['cardtarget']) &&
            !isset($columns['cardlinktitle']) &&
            !isset($columns['cardtitletext']);
    }

    public function run(): MigrationResult
    {
        $this->connection->executeStatement("
            ALTER TABLE
                tl_content

            ADD cardUrl text NULL,
            ADD cardTarget char(1) NOT NULL default '',
            ADD cardLinkTitle varchar(255) NOT NULL DEFAULT '',
            ADD cardTitleText varchar(255) NOT NULL DEFAULT ''
        ");

        $this->connection->executeStatement('
            UPDATE
                tl_content
            SET
                cardUrl = url,
                cardTarget = target,
                cardLinkTitle = linkTitle,
                cardTitleText = titleText
            WHERE
                type = :type
        ', ['type' => 'card']);

        return $this->createResult(true, 'Use separate link fields for card-element');
    }
}
