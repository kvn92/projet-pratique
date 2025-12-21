<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251221123955 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(40) NOT NULL, is_active TINYINT DEFAULT 0 NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_CATEGORY_IS_ACTIVE (is_active), UNIQUE INDEX UNIQ_CATEGORY_NOM (nom), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, is_active TINYINT DEFAULT 0 NOT NULL, create_at DATETIME NOT NULL, update_at DATETIME DEFAULT NULL, slug VARCHAR(255) NOT NULL, user_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_B6BD307FA76ED395 (user_id), INDEX IDX_B6BD307F12469DE2 (category_id), INDEX IDX_MESSAGE_IS_ACTIVE (is_active), UNIQUE INDEX UNIQ_TITRE (titre), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(30) NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_active TINYINT DEFAULT 0 NOT NULL, create_at DATETIME NOT NULL, update_at DATETIME DEFAULT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_USER_IS_ACTIVE (is_active), UNIQUE INDEX UNIQ_USERNAME (username), UNIQUE INDEX UNIQ_EMAIL (email), UNIQUE INDEX UNIQ_USERNAME_EMAIL (username, email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FA76ED395');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F12469DE2');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE `user`');
    }
}
