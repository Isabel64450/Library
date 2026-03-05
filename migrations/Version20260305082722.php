<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260305082722 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE loan ADD book_id_id INT NOT NULL, ADD user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE loan ADD CONSTRAINT FK_C5D30D0371868B2E FOREIGN KEY (book_id_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE loan ADD CONSTRAINT FK_C5D30D039D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C5D30D0371868B2E ON loan (book_id_id)');
        $this->addSql('CREATE INDEX IDX_C5D30D039D86650F ON loan (user_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE loan DROP FOREIGN KEY FK_C5D30D0371868B2E');
        $this->addSql('ALTER TABLE loan DROP FOREIGN KEY FK_C5D30D039D86650F');
        $this->addSql('DROP INDEX IDX_C5D30D0371868B2E ON loan');
        $this->addSql('DROP INDEX IDX_C5D30D039D86650F ON loan');
        $this->addSql('ALTER TABLE loan DROP book_id_id, DROP user_id_id');
    }
}
