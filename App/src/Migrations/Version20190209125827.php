<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190209125827 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE categorie_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE competence_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE competence_posseder_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE devis_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE facture_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE freelancer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE projet_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE type_projet_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_perhaps_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE categorie (id INT NOT NULL, nom_categorie VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE competence (id INT NOT NULL, nom_competence VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE competence_posseder (id INT NOT NULL, notation INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE devis (id INT NOT NULL, description_devis TEXT NOT NULL, offre_devis INT DEFAULT NULL, delai_devis INT DEFAULT NULL, date_devis DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE facture (id INT NOT NULL, nom_facture VARCHAR(50) NOT NULL, prix_ttc DOUBLE PRECISION NOT NULL, prix_ht DOUBLE PRECISION NOT NULL, nbr_heures INT NOT NULL, taux_h DOUBLE PRECISION NOT NULL, autres_charges DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE freelancer (id INT NOT NULL, nom_freelancer VARCHAR(150) NOT NULL, prenom_freelancer VARCHAR(150) NOT NULL, email_freelancer VARCHAR(255) NOT NULL, password_freelancer VARCHAR(255) NOT NULL, adresse_freelancer VARCHAR(200) NOT NULL, cp_freelancer VARCHAR(5) NOT NULL, ville_freelancer VARCHAR(150) NOT NULL, pays_freelancer VARCHAR(150) NOT NULL, phone_freelancer VARCHAR(10) NOT NULL, statut_freelancer VARCHAR(150) NOT NULL, tarif_horaire_freelancer INT NOT NULL, presentation_freelancer VARCHAR(255) NOT NULL, nom_societe_freelancer VARCHAR(150) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE projet (id INT NOT NULL, nom_projet VARCHAR(50) NOT NULL, description_projet TEXT NOT NULL, budget INT NOT NULL, date_debut DATE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, is_visible BOOLEAN DEFAULT \'true\' NOT NULL, choix_contact INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE type_projet (id INT NOT NULL, nom_type VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE user_perhaps (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles TEXT NOT NULL, password VARCHAR(255) NOT NULL, nom_user VARCHAR(50) NOT NULL, prenom_user VARCHAR(50) NOT NULL, telephone_user VARCHAR(50) NOT NULL, adresse_user VARCHAR(255) NOT NULL, code_postale_user VARCHAR(50) NOT NULL, ville VARCHAR(50) NOT NULL, pays VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A3961B92E7927C74 ON user_perhaps (email)');
        $this->addSql('COMMENT ON COLUMN user_perhaps.roles IS \'(DC2Type:json)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE categorie_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE competence_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE competence_posseder_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE devis_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE facture_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE freelancer_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE projet_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE type_projet_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_perhaps_id_seq CASCADE');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE competence');
        $this->addSql('DROP TABLE competence_posseder');
        $this->addSql('DROP TABLE devis');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE freelancer');
        $this->addSql('DROP TABLE projet');
        $this->addSql('DROP TABLE type_projet');
        $this->addSql('DROP TABLE user_perhaps');
    }
}
