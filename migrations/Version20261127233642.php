<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261127233642 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, unit VARCHAR(50) NOT NULL, frequency_days INT NOT NULL, user_id INT NOT NULL, UNIQUE INDEX UNIQ_USER_CATEGORY_NAME (user_id, name), INDEX IDX_64C19C1A76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE goal (id INT AUTO_INCREMENT NOT NULL, start_value DOUBLE PRECISION NOT NULL, target_value DOUBLE PRECISION NOT NULL, category_id INT NOT NULL, UNIQUE INDEX UNIQ_FCDCEB2E12469DE2 (category_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE measurement (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, value DOUBLE PRECISION NOT NULL, category_id INT NOT NULL, INDEX IDX_2CE0D81112469DE2 (category_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(180) NOT NULL, role VARCHAR(255) NOT NULL, password_hash VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_LOGIN (login), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user_settings (id INT AUTO_INCREMENT NOT NULL, theme VARCHAR(30) NOT NULL, font_size VARCHAR(20) NOT NULL, user_id INT NOT NULL, UNIQUE INDEX UNIQ_5C844C5A76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id))');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE goal ADD CONSTRAINT FK_FCDCEB2E12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE measurement ADD CONSTRAINT FK_2CE0D81112469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_settings ADD CONSTRAINT FK_5C844C5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1A76ED395');
        $this->addSql('ALTER TABLE goal DROP FOREIGN KEY FK_FCDCEB2E12469DE2');
        $this->addSql('ALTER TABLE measurement DROP FOREIGN KEY FK_2CE0D81112469DE2');
        $this->addSql('ALTER TABLE user_settings DROP FOREIGN KEY FK_5C844C5A76ED395');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE goal');
        $this->addSql('DROP TABLE measurement');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_settings');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
