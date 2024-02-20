<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240220203050 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE suivi_livraison ADD idcomm_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE suivi_livraison ADD CONSTRAINT FK_CFAC6471307AE6E7 FOREIGN KEY (idcomm_id) REFERENCES commande (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CFAC6471307AE6E7 ON suivi_livraison (idcomm_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE suivi_livraison DROP FOREIGN KEY FK_CFAC6471307AE6E7');
        $this->addSql('DROP INDEX UNIQ_CFAC6471307AE6E7 ON suivi_livraison');
        $this->addSql('ALTER TABLE suivi_livraison DROP idcomm_id');
    }
}
