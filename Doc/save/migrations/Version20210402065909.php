<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210402065909 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE place ADD image VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE place_category ADD image VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE product_category ADD image VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE place DROP image');
        $this->addSql('ALTER TABLE place_category DROP image');
        $this->addSql('ALTER TABLE product_category DROP image');
    }
}
