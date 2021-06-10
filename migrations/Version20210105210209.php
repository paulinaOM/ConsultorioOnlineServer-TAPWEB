<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210105210209 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bill CHANGE id_consultation id_consultation INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bill ADD CONSTRAINT FK_7A2119E3B587F0D4 FOREIGN KEY (id_consultation) REFERENCES medical_consultation (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7A2119E3B587F0D4 ON bill (id_consultation)');
        $this->addSql('ALTER TABLE prescription ADD CONSTRAINT FK_1FBFB8D98EDC618 FOREIGN KEY (id_medicine) REFERENCES medicine (id)');
        $this->addSql('ALTER TABLE prescription ADD CONSTRAINT FK_1FBFB8D9B587F0D4 FOREIGN KEY (id_consultation) REFERENCES medical_consultation (id)');
        $this->addSql('CREATE INDEX IDX_1FBFB8D98EDC618 ON prescription (id_medicine)');
        $this->addSql('CREATE INDEX IDX_1FBFB8D9B587F0D4 ON prescription (id_consultation)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bill DROP FOREIGN KEY FK_7A2119E3B587F0D4');
        $this->addSql('DROP INDEX UNIQ_7A2119E3B587F0D4 ON bill');
        $this->addSql('ALTER TABLE bill CHANGE id_consultation id_consultation INT NOT NULL');
        $this->addSql('ALTER TABLE prescription DROP FOREIGN KEY FK_1FBFB8D98EDC618');
        $this->addSql('ALTER TABLE prescription DROP FOREIGN KEY FK_1FBFB8D9B587F0D4');
        $this->addSql('DROP INDEX IDX_1FBFB8D98EDC618 ON prescription');
        $this->addSql('DROP INDEX IDX_1FBFB8D9B587F0D4 ON prescription');
    }
}
