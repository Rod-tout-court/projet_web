<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231124070053 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1052Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDb1052Platform'."
        );

        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_880E0D7686CC499D (pseudo), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1052Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDb1052Platform'."
        );

        $this->addSql('CREATE TABLE favorite (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, id_gif_id INT NOT NULL, INDEX IDX_68C58ED979F37AE5 (id_user_id), INDEX IDX_68C58ED9916B8A6D (id_gif_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1052Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDb1052Platform'."
        );

        $this->addSql('CREATE TABLE gif (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, tags LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', visible TINYINT(1) NOT NULL, INDEX IDX_A2371034F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1052Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDb1052Platform'."
        );

        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, headers LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, queue_name VARCHAR(190) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), INDEX IDX_75EA56E0FB7336F0 (queue_name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1052Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDb1052Platform'."
        );

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, mail VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', UNIQUE INDEX UNIQ_8D93D64986CC499D (pseudo), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1052Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDb1052Platform'."
        );

        $this->addSql('CREATE TABLE vote (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, id_gif_id INT NOT NULL, `values` SMALLINT NOT NULL, INDEX IDX_5A108564916B8A6D (id_gif_id), INDEX IDX_5A10856479F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1052Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDb1052Platform'."
        );

        $this->addSql('DROP TABLE admin');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1052Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDb1052Platform'."
        );

        $this->addSql('DROP TABLE favorite');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1052Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDb1052Platform'."
        );

        $this->addSql('DROP TABLE gif');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1052Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDb1052Platform'."
        );

        $this->addSql('DROP TABLE messenger_messages');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1052Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDb1052Platform'."
        );

        $this->addSql('DROP TABLE user');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1052Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDb1052Platform'."
        );

        $this->addSql('DROP TABLE vote');
    }
}
