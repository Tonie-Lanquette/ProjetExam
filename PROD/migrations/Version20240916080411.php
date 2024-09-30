<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240916080411 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE build DROP INDEX UNIQ_BDA0F2DB61220EA6, ADD INDEX IDX_BDA0F2DB61220EA6 (creator_id)');
        $this->addSql('ALTER TABLE build CHANGE creator_id creator_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE build DROP INDEX IDX_BDA0F2DB61220EA6, ADD UNIQUE INDEX UNIQ_BDA0F2DB61220EA6 (creator_id)');
        $this->addSql('ALTER TABLE build CHANGE creator_id creator_id INT NOT NULL');
    }
}
