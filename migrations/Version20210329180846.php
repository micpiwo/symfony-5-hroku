<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210329180846 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produits DROP INDEX UNIQ_BE2DDF8C8A3C7387, ADD INDEX IDX_BE2DDF8C8A3C7387 (categorie_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produits DROP INDEX IDX_BE2DDF8C8A3C7387, ADD UNIQUE INDEX UNIQ_BE2DDF8C8A3C7387 (categorie_id_id)');
    }
}
