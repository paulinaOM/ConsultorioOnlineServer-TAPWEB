<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210105195921 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consultation_service DROP id_doctor');
        $this->addSql('ALTER TABLE consultation_service ADD CONSTRAINT FK_A49E6B30B587F0D4 FOREIGN KEY (id_consultation) REFERENCES medical_consultation (id)');
        $this->addSql('ALTER TABLE consultation_service ADD CONSTRAINT FK_A49E6B303F0033A2 FOREIGN KEY (id_service) REFERENCES doctor_service (id)');
        $this->addSql('CREATE INDEX IDX_A49E6B30B587F0D4 ON consultation_service (id_consultation)');
        $this->addSql('CREATE INDEX IDX_A49E6B303F0033A2 ON consultation_service (id_service)');
        $this->addSql('ALTER TABLE medical_consultation ADD CONSTRAINT FK_B3BBAEC939F74687 FOREIGN KEY (id_doctor) REFERENCES doctor (id)');
        $this->addSql('ALTER TABLE medical_consultation ADD CONSTRAINT FK_B3BBAEC9C4477E9B FOREIGN KEY (id_patient) REFERENCES patient (id)');
        $this->addSql('CREATE INDEX IDX_B3BBAEC939F74687 ON medical_consultation (id_doctor)');
        $this->addSql('CREATE INDEX IDX_B3BBAEC9C4477E9B ON medical_consultation (id_patient)');
        $this->addSql('ALTER TABLE tax_data ADD CONSTRAINT FK_B17CFC9BC4477E9B FOREIGN KEY (id_patient) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE tax_data ADD CONSTRAINT FK_B17CFC9BB3B52D7D FOREIGN KEY (id_payment) REFERENCES payment (id)');
        $this->addSql('CREATE INDEX IDX_B17CFC9BC4477E9B ON tax_data (id_patient)');
        $this->addSql('CREATE INDEX IDX_B17CFC9BB3B52D7D ON tax_data (id_payment)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consultation_service DROP FOREIGN KEY FK_A49E6B30B587F0D4');
        $this->addSql('ALTER TABLE consultation_service DROP FOREIGN KEY FK_A49E6B303F0033A2');
        $this->addSql('DROP INDEX IDX_A49E6B30B587F0D4 ON consultation_service');
        $this->addSql('DROP INDEX IDX_A49E6B303F0033A2 ON consultation_service');
        $this->addSql('ALTER TABLE consultation_service ADD id_doctor INT NOT NULL');
        $this->addSql('ALTER TABLE medical_consultation DROP FOREIGN KEY FK_B3BBAEC939F74687');
        $this->addSql('ALTER TABLE medical_consultation DROP FOREIGN KEY FK_B3BBAEC9C4477E9B');
        $this->addSql('DROP INDEX IDX_B3BBAEC939F74687 ON medical_consultation');
        $this->addSql('DROP INDEX IDX_B3BBAEC9C4477E9B ON medical_consultation');
        $this->addSql('ALTER TABLE tax_data DROP FOREIGN KEY FK_B17CFC9BC4477E9B');
        $this->addSql('ALTER TABLE tax_data DROP FOREIGN KEY FK_B17CFC9BB3B52D7D');
        $this->addSql('DROP INDEX IDX_B17CFC9BC4477E9B ON tax_data');
        $this->addSql('DROP INDEX IDX_B17CFC9BB3B52D7D ON tax_data');
    }
}
