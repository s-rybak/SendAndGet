<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181222112720 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE file ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE file_user ADD status VARCHAR(100) NOT NULL, ADD count INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD ip VARCHAR(100) NOT NULL, ADD status VARCHAR(100) NOT NULL, ADD device TEXT NOT NULL, ADD user_roles TEXT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE file DROP user_id');
        $this->addSql('ALTER TABLE file_user DROP status, DROP count');
        $this->addSql('ALTER TABLE user DROP ip, DROP device, DROP user_roles, DROP status');
    }
}
