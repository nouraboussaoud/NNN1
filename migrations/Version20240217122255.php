<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240217122255 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE livraison (id INT AUTO_INCREMENT NOT NULL, id_commande_id INT DEFAULT NULL, id_client_id INT DEFAULT NULL, id_livreur_id INT DEFAULT NULL, nom_c VARCHAR(255) NOT NULL, prenom_c VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, type_paiement VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_A60C9F1F9AF8E3A3 (id_commande_id), INDEX IDX_A60C9F1F99DED506 (id_client_id), INDEX IDX_A60C9F1F5DEEE7D6 (id_livreur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE paiement (id INT AUTO_INCREMENT NOT NULL, id_liv_id INT DEFAULT NULL, id_us_id INT DEFAULT NULL, montant DOUBLE PRECISION NOT NULL, etat VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_B1DC7A1EABB52D31 (id_liv_id), UNIQUE INDEX UNIQ_B1DC7A1EF91FCAC2 (id_us_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE suivi_livraison (id INT AUTO_INCREMENT NOT NULL, id_livraison_id INT DEFAULT NULL, date_comm DATE NOT NULL, localisatione VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_CFAC6471AD958E57 (id_livraison_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1F9AF8E3A3 FOREIGN KEY (id_commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1F99DED506 FOREIGN KEY (id_client_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1F5DEEE7D6 FOREIGN KEY (id_livreur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1EABB52D31 FOREIGN KEY (id_liv_id) REFERENCES livraison (id)');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1EF91FCAC2 FOREIGN KEY (id_us_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE suivi_livraison ADD CONSTRAINT FK_CFAC6471AD958E57 FOREIGN KEY (id_livraison_id) REFERENCES livraison (id)');
        $this->addSql('ALTER TABLE quiz ADD points INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1F9AF8E3A3');
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1F99DED506');
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1F5DEEE7D6');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1EABB52D31');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1EF91FCAC2');
        $this->addSql('ALTER TABLE suivi_livraison DROP FOREIGN KEY FK_CFAC6471AD958E57');
        $this->addSql('DROP TABLE livraison');
        $this->addSql('DROP TABLE paiement');
        $this->addSql('DROP TABLE suivi_livraison');
        $this->addSql('ALTER TABLE quiz DROP points');
    }
}
