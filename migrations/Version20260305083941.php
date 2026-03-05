<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260305083941 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE loan CHANGE status status VARCHAR(180) DEFAULT \'current\' NOT NULL');
        $this->addSql('ALTER TABLE loan ADD CONSTRAINT FK_C5D30D0316A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE loan ADD CONSTRAINT FK_C5D30D03A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE loan RENAME INDEX idx_c5d30d0371868b2e TO IDX_C5D30D0316A2B381');
        $this->addSql('ALTER TABLE loan RENAME INDEX idx_c5d30d039d86650f TO IDX_C5D30D03A76ED395');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE loan DROP FOREIGN KEY FK_C5D30D0316A2B381');
        $this->addSql('ALTER TABLE loan DROP FOREIGN KEY FK_C5D30D03A76ED395');
        $this->addSql('ALTER TABLE loan CHANGE status status VARCHAR(180) NOT NULL');
        $this->addSql('ALTER TABLE loan RENAME INDEX idx_c5d30d0316a2b381 TO IDX_C5D30D0371868B2E');
        $this->addSql('ALTER TABLE loan RENAME INDEX idx_c5d30d03a76ed395 TO IDX_C5D30D039D86650F');
    }
}
