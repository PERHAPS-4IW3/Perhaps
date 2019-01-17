<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190116095635 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE categorie_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE competence_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE competence_posseder_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE facture_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE projet_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE type_projet_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE categorie (id INT NOT NULL, nom_categorie VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE competence (id INT NOT NULL, nom_competence VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE competence_posseder (id INT NOT NULL, notation INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE facture (id INT NOT NULL, nom_facture VARCHAR(50) NOT NULL, prix_ttc INT NOT NULL, prix_ht INT NOT NULL, nbr_heures INT NOT NULL, taux_h INT NOT NULL, autres_charges DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE projet (id INT NOT NULL, nom_projet VARCHAR(50) NOT NULL, description_projet TEXT NOT NULL, temps VARCHAR(50) NOT NULL, budget INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE type_projet (id INT NOT NULL, nom_type VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE categorie_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE competence_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE competence_posseder_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE facture_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE projet_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE type_projet_id_seq CASCADE');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE competence');
        $this->addSql('DROP TABLE competence_posseder');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE projet');
        $this->addSql('DROP TABLE type_projet');
    }
}
