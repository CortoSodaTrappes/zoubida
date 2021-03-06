<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180807102826 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lessons DROP FOREIGN KEY FK_3F4218D942AFE4F1');
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP INDEX IDX_3F4218D942AFE4F1 ON lessons');
        $this->addSql('ALTER TABLE lessons CHANGE lesson lesson LONGTEXT NOT NULL, CHANGE name name VARCHAR(75) NOT NULL, CHANGE categorie_id_categorie_id idcategories_id INT NOT NULL');
        $this->addSql('ALTER TABLE lessons ADD CONSTRAINT FK_3F4218D9DB88036C FOREIGN KEY (idcategories_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX IDX_3F4218D9DB88036C ON lessons (idcategories_id)');
        $this->addSql('ALTER TABLE users ADD password VARCHAR(80) NOT NULL, CHANGE created created DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lessons DROP FOREIGN KEY FK_3F4218D9DB88036C');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP INDEX IDX_3F4218D9DB88036C ON lessons');
        $this->addSql('ALTER TABLE lessons CHANGE name name VARCHAR(45) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE lesson lesson VARCHAR(45) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE idcategories_id categorie_id_categorie_id INT NOT NULL');
        $this->addSql('ALTER TABLE lessons ADD CONSTRAINT FK_3F4218D942AFE4F1 FOREIGN KEY (categorie_id_categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_3F4218D942AFE4F1 ON lessons (categorie_id_categorie_id)');
        $this->addSql('ALTER TABLE users DROP password, CHANGE created created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
    }
}
