<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200410145701 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $schema = new Schema();

        $table = $schema->createTable('search_index');
        $table->addColumn('id', 'integer', array('autoincrement' => true));
        $table->addColumn('tel', 'string');
        $table->addColumn('country', 'string');
        $table->addColumn('region', 'string');
        $table->addColumn('timezone', 'string');
        $table->addColumn('company', 'string');
        $table->setPrimaryKey(array('id'));

        return $schema;
    }

    public function down(Schema $schema) : void
    {
        $this->addSql();
        $this->addSql();
        $this->addSql();
    }
}
