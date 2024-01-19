<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231217170045 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, price NUMERIC(10, 0) NOT NULL, duree INT NOT NULL, beginat DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participant_formation (participant_id INT NOT NULL, formation_id INT NOT NULL, INDEX IDX_8342EE9B9D1C3019 (participant_id), INDEX IDX_8342EE9B5200282E (formation_id), PRIMARY KEY(participant_id, formation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE participant_formation ADD CONSTRAINT FK_8342EE9B9D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participant_formation ADD CONSTRAINT FK_8342EE9B5200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participant_formation DROP FOREIGN KEY FK_8342EE9B9D1C3019');
        $this->addSql('ALTER TABLE participant_formation DROP FOREIGN KEY FK_8342EE9B5200282E');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE participant_formation');
    }
}
