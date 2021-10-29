<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211029085010 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE "user" (id UUID NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, phone VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, roles TEXT NOT NULL, force_change_password BOOLEAN DEFAULT \'false\' NOT NULL, created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('COMMENT ON COLUMN "user".id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN "user".roles IS \'(DC2Type:array)\'');
        $this->addSql('INSERT INTO public."user" VALUES (\'3a86f15c-dd80-41d2-81d6-a670875e2d11\', \'admin\', \'admin\', \'admin@admin.com\', \'0000000000\', \'\$2y\$13\$w0HyD6APj7f0AZaaI6V3UOADJH7p3QpSK/Y/Tpp1hp5nYV3LoLFbO\', \'a:1:{i:0;s:16:"ROLE_SUPER_ADMIN";}\', \'false\',\'2020-08-18 11:46:06+00\', \'2020-08-18 11:46:06+00\')');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE "user"');
    }
}
