<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210329175449 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produits ADD categorie_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produits ADD CONSTRAINT FK_BE2DDF8C8A3C7387 FOREIGN KEY (categorie_id_id) REFERENCES categories (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BE2DDF8C8A3C7387 ON produits (categorie_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produits DROP FOREIGN KEY FK_BE2DDF8C8A3C7387');
        $this->addSql('DROP INDEX UNIQ_BE2DDF8C8A3C7387 ON produits');
        $this->addSql('ALTER TABLE produits DROP categorie_id_id');
    }
}
