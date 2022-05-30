<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220530132534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE link_statistic (id INT AUTO_INCREMENT NOT NULL, link_id INT NOT NULL, country VARCHAR(55) DEFAULT NULL, time INT DEFAULT NULL, INDEX IDX_86EE96E853B6268F (link_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE link_statistic ADD CONSTRAINT FK_86EE96E853B6268F FOREIGN KEY (link_id) REFERENCES link (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE link_statistic');
    }
}
