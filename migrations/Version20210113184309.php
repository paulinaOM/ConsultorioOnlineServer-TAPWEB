<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210113184309 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bill CHANGE filename filename VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE prescription DROP FOREIGN KEY FK_1FBFB8D98EDC618');
        $this->addSql('DROP INDEX IDX_1FBFB8D98EDC618 ON prescription');
        $this->addSql('ALTER TABLE prescription ADD filename VARCHAR(30) NOT NULL, DROP id_medicine, DROP instructions');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bill CHANGE filename filename VARCHAR(15) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE prescription ADD id_medicine INT NOT NULL, ADD instructions LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP filename');
        $this->addSql('ALTER TABLE prescription ADD CONSTRAINT FK_1FBFB8D98EDC618 FOREIGN KEY (id_medicine) REFERENCES medicine (id)');
        $this->addSql('CREATE INDEX IDX_1FBFB8D98EDC618 ON prescription (id_medicine)');
    }
}
