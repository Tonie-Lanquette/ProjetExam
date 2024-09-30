<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240909123744 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, build_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, introduction LONGTEXT NOT NULL, starter_explication LONGTEXT NOT NULL, core_explication LONGTEXT NOT NULL, optional_explication LONGTEXT NOT NULL, conclusion LONGTEXT NOT NULL, INDEX IDX_23A0E66A76ED395 (user_id), UNIQUE INDEX UNIQ_23A0E6617C13F8B (build_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE build (id INT AUTO_INCREMENT NOT NULL, creator_id INT NOT NULL, champion_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, visibility TINYINT(1) NOT NULL, created DATE NOT NULL, updated DATE NOT NULL, UNIQUE INDEX UNIQ_BDA0F2DB61220EA6 (creator_id), INDEX IDX_BDA0F2DBFA7FD7EB (champion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE champion (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, role VARCHAR(255) NOT NULL, splash_art VARCHAR(255) NOT NULL, `key` INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ennemy (id INT AUTO_INCREMENT NOT NULL, build_id INT DEFAULT NULL, category VARCHAR(255) NOT NULL, INDEX IDX_A396A3EF17C13F8B (build_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ennemy_champion (ennemy_id INT NOT NULL, champion_id INT NOT NULL, INDEX IDX_B95EB5C758B98B55 (ennemy_id), INDEX IDX_B95EB5C7FA7FD7EB (champion_id), PRIMARY KEY(ennemy_id, champion_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, icon VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, cost INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slot (id INT AUTO_INCREMENT NOT NULL, build_id INT DEFAULT NULL, category VARCHAR(255) NOT NULL, INDEX IDX_AC0E206717C13F8B (build_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slot_item (slot_id INT NOT NULL, item_id INT NOT NULL, INDEX IDX_C1328F8959E5119C (slot_id), INDEX IDX_C1328F89126F525E (item_id), PRIMARY KEY(slot_id, item_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, gdpr DATETIME NOT NULL, updated DATE DEFAULT NULL, created DATE DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_champion (user_id INT NOT NULL, champion_id INT NOT NULL, INDEX IDX_A5CE9AB4A76ED395 (user_id), INDEX IDX_A5CE9AB4FA7FD7EB (champion_id), PRIMARY KEY(user_id, champion_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vote (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, build_id INT DEFAULT NULL, vote TINYINT(1) NOT NULL, INDEX IDX_5A108564A76ED395 (user_id), INDEX IDX_5A10856417C13F8B (build_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6617C13F8B FOREIGN KEY (build_id) REFERENCES build (id)');
        $this->addSql('ALTER TABLE build ADD CONSTRAINT FK_BDA0F2DB61220EA6 FOREIGN KEY (creator_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE build ADD CONSTRAINT FK_BDA0F2DBFA7FD7EB FOREIGN KEY (champion_id) REFERENCES champion (id)');
        $this->addSql('ALTER TABLE ennemy ADD CONSTRAINT FK_A396A3EF17C13F8B FOREIGN KEY (build_id) REFERENCES build (id)');
        $this->addSql('ALTER TABLE ennemy_champion ADD CONSTRAINT FK_B95EB5C758B98B55 FOREIGN KEY (ennemy_id) REFERENCES ennemy (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ennemy_champion ADD CONSTRAINT FK_B95EB5C7FA7FD7EB FOREIGN KEY (champion_id) REFERENCES champion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE slot ADD CONSTRAINT FK_AC0E206717C13F8B FOREIGN KEY (build_id) REFERENCES build (id)');
        $this->addSql('ALTER TABLE slot_item ADD CONSTRAINT FK_C1328F8959E5119C FOREIGN KEY (slot_id) REFERENCES slot (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE slot_item ADD CONSTRAINT FK_C1328F89126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_champion ADD CONSTRAINT FK_A5CE9AB4A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_champion ADD CONSTRAINT FK_A5CE9AB4FA7FD7EB FOREIGN KEY (champion_id) REFERENCES champion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A10856417C13F8B FOREIGN KEY (build_id) REFERENCES build (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66A76ED395');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6617C13F8B');
        $this->addSql('ALTER TABLE build DROP FOREIGN KEY FK_BDA0F2DB61220EA6');
        $this->addSql('ALTER TABLE build DROP FOREIGN KEY FK_BDA0F2DBFA7FD7EB');
        $this->addSql('ALTER TABLE ennemy DROP FOREIGN KEY FK_A396A3EF17C13F8B');
        $this->addSql('ALTER TABLE ennemy_champion DROP FOREIGN KEY FK_B95EB5C758B98B55');
        $this->addSql('ALTER TABLE ennemy_champion DROP FOREIGN KEY FK_B95EB5C7FA7FD7EB');
        $this->addSql('ALTER TABLE slot DROP FOREIGN KEY FK_AC0E206717C13F8B');
        $this->addSql('ALTER TABLE slot_item DROP FOREIGN KEY FK_C1328F8959E5119C');
        $this->addSql('ALTER TABLE slot_item DROP FOREIGN KEY FK_C1328F89126F525E');
        $this->addSql('ALTER TABLE user_champion DROP FOREIGN KEY FK_A5CE9AB4A76ED395');
        $this->addSql('ALTER TABLE user_champion DROP FOREIGN KEY FK_A5CE9AB4FA7FD7EB');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A108564A76ED395');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A10856417C13F8B');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE build');
        $this->addSql('DROP TABLE champion');
        $this->addSql('DROP TABLE ennemy');
        $this->addSql('DROP TABLE ennemy_champion');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE slot');
        $this->addSql('DROP TABLE slot_item');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE user_champion');
        $this->addSql('DROP TABLE vote');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
