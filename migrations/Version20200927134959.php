<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200927134959 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blog_posts (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, title VARCHAR(150) NOT NULL, date_time DATETIME NOT NULL, post_img VARCHAR(100) DEFAULT NULL, content LONGTEXT NOT NULL, INDEX IDX_78B2F932A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_comments (id INT AUTO_INCREMENT NOT NULL, post_id INT NOT NULL, user_id INT DEFAULT NULL, comment VARCHAR(2000) NOT NULL, is_hidden TINYINT(1) NOT NULL, date_time DATETIME NOT NULL, INDEX IDX_E0731F8B4B89032C (post_id), INDEX IDX_E0731F8BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blog_posts ADD CONSTRAINT FK_78B2F932A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE post_comments ADD CONSTRAINT FK_E0731F8B4B89032C FOREIGN KEY (post_id) REFERENCES blog_posts (id)');
        $this->addSql('ALTER TABLE post_comments ADD CONSTRAINT FK_E0731F8BA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post_comments DROP FOREIGN KEY FK_E0731F8B4B89032C');
        $this->addSql('ALTER TABLE blog_posts DROP FOREIGN KEY FK_78B2F932A76ED395');
        $this->addSql('ALTER TABLE post_comments DROP FOREIGN KEY FK_E0731F8BA76ED395');
        $this->addSql('DROP TABLE blog_posts');
        $this->addSql('DROP TABLE post_comments');
        $this->addSql('DROP TABLE users');
    }
}
