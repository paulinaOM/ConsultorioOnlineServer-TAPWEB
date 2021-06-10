<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210104181900 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10CB587F0D4 FOREIGN KEY (id_consultation) REFERENCES medical_consultation (id)');
        $this->addSql('CREATE INDEX IDX_6A2CA10CB587F0D4 ON media (id_consultation)');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EB6B3CA4B FOREIGN KEY (id_user) REFERENCES userdata (id)');
        $this->addSql('CREATE INDEX IDX_1ADAD7EB6B3CA4B ON patient (id_user)');
        $this->addSql('ALTER TABLE patient_allergy ADD CONSTRAINT FK_96D2175EC4477E9B FOREIGN KEY (id_patient) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE patient_allergy ADD CONSTRAINT FK_96D2175E152CEBC5 FOREIGN KEY (id_allergy) REFERENCES allergy (id)');
        $this->addSql('CREATE INDEX IDX_96D2175EC4477E9B ON patient_allergy (id_patient)');
        $this->addSql('CREATE INDEX IDX_96D2175E152CEBC5 ON patient_allergy (id_allergy)');
        $this->addSql('ALTER TABLE patient_disease ADD CONSTRAINT FK_52583F2AC4477E9B FOREIGN KEY (id_patient) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE patient_disease ADD CONSTRAINT FK_52583F2AD1A6C3B1 FOREIGN KEY (id_disease) REFERENCES chronic_disease (id)');
        $this->addSql('CREATE INDEX IDX_52583F2AC4477E9B ON patient_disease (id_patient)');
        $this->addSql('CREATE INDEX IDX_52583F2AD1A6C3B1 ON patient_disease (id_disease)');
        $this->addSql('ALTER TABLE patient_surgery ADD CONSTRAINT FK_194F7B63C4477E9B FOREIGN KEY (id_patient) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE patient_surgery ADD CONSTRAINT FK_194F7B639AB187F8 FOREIGN KEY (id_surgery) REFERENCES surgery (id)');
        $this->addSql('CREATE INDEX IDX_194F7B63C4477E9B ON patient_surgery (id_patient)');
        $this->addSql('CREATE INDEX IDX_194F7B639AB187F8 ON patient_surgery (id_surgery)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10CB587F0D4');
        $this->addSql('DROP INDEX IDX_6A2CA10CB587F0D4 ON media');
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EB6B3CA4B');
        $this->addSql('DROP INDEX IDX_1ADAD7EB6B3CA4B ON patient');
        $this->addSql('ALTER TABLE patient_allergy DROP FOREIGN KEY FK_96D2175EC4477E9B');
        $this->addSql('ALTER TABLE patient_allergy DROP FOREIGN KEY FK_96D2175E152CEBC5');
        $this->addSql('DROP INDEX IDX_96D2175EC4477E9B ON patient_allergy');
        $this->addSql('DROP INDEX IDX_96D2175E152CEBC5 ON patient_allergy');
        $this->addSql('ALTER TABLE patient_disease DROP FOREIGN KEY FK_52583F2AC4477E9B');
        $this->addSql('ALTER TABLE patient_disease DROP FOREIGN KEY FK_52583F2AD1A6C3B1');
        $this->addSql('DROP INDEX IDX_52583F2AC4477E9B ON patient_disease');
        $this->addSql('DROP INDEX IDX_52583F2AD1A6C3B1 ON patient_disease');
        $this->addSql('ALTER TABLE patient_surgery DROP FOREIGN KEY FK_194F7B63C4477E9B');
        $this->addSql('ALTER TABLE patient_surgery DROP FOREIGN KEY FK_194F7B639AB187F8');
        $this->addSql('DROP INDEX IDX_194F7B63C4477E9B ON patient_surgery');
        $this->addSql('DROP INDEX IDX_194F7B639AB187F8 ON patient_surgery');
    }
}
