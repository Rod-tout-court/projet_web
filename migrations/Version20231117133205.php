<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231117133205 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_880E0D7686CC499D (pseudo), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favorite (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, id_gif_id INT NOT NULL, INDEX IDX_68C58ED979F37AE5 (id_user_id), INDEX IDX_68C58ED9916B8A6D (id_gif_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gif (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, name VARCHAR(255) NOT NULL, tags LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', visible TINYINT(1) NOT NULL, INDEX IDX_A2371034F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vote (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, id_gif_id INT NOT NULL, `values` SMALLINT NOT NULL, INDEX IDX_5A10856479F37AE5 (id_user_id), INDEX IDX_5A108564916B8A6D (id_gif_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED979F37AE5 FOREIGN KEY (id_user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED9916B8A6D FOREIGN KEY (id_gif_id) REFERENCES gif (id)');
        $this->addSql('ALTER TABLE gif ADD CONSTRAINT FK_A2371034F675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A10856479F37AE5 FOREIGN KEY (id_user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564916B8A6D FOREIGN KEY (id_gif_id) REFERENCES gif (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favorite DROP FOREIGN KEY FK_68C58ED979F37AE5');
        $this->addSql('ALTER TABLE favorite DROP FOREIGN KEY FK_68C58ED9916B8A6D');
        $this->addSql('ALTER TABLE gif DROP FOREIGN KEY FK_A2371034F675F31B');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A10856479F37AE5');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A108564916B8A6D');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE favorite');
        $this->addSql('DROP TABLE gif');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE vote');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
