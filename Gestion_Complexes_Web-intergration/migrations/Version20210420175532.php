<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210420175532 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE app_users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(25) NOT NULL, password VARCHAR(64) NOT NULL, email VARCHAR(254) NOT NULL, is_active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_C2502824F85E0677 (username), UNIQUE INDEX UNIQ_C2502824E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, nsc VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE acceptation_reservation CHANGE reservation reservation INT DEFAULT NULL, CHANGE client client INT DEFAULT NULL');
        $this->addSql('ALTER TABLE competition CHANGE categorie categorie INT DEFAULT NULL, CHANGE complexe complexe INT DEFAULT NULL');
        $this->addSql('ALTER TABLE equipe CHANGE capitain capitain INT DEFAULT NULL');
        $this->addSql('ALTER TABLE invitation CHANGE utilisateur utilisateur INT DEFAULT NULL');
        $this->addSql('ALTER TABLE matche DROP competition');
        $this->addSql('ALTER TABLE niveau_competition CHANGE competition competition INT DEFAULT NULL');
        $this->addSql('ALTER TABLE participation CHANGE competition competition INT DEFAULT NULL, CHANGE equipe equipe INT DEFAULT NULL');
        $this->addSql('ALTER TABLE penalite CHANGE complexe complexe INT DEFAULT NULL');
        $this->addSql('ALTER TABLE penalite_joueur CHANGE penalite penalite INT DEFAULT NULL, CHANGE arbitre arbitre INT DEFAULT NULL, CHANGE joueur joueur INT DEFAULT NULL, CHANGE matche matche INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation CHANGE heure heure TIME NOT NULL, CHANGE validee validee TINYINT(1) NOT NULL, CHANGE montant montant DOUBLE PRECISION NOT NULL, CHANGE acceptee acceptee TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE terrain CHANGE complexe complexe INT DEFAULT NULL, CHANGE categorie categorie INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE app_users');
        $this->addSql('DROP TABLE student');
        $this->addSql('ALTER TABLE acceptation_reservation CHANGE client client INT NOT NULL, CHANGE reservation reservation INT NOT NULL');
        $this->addSql('ALTER TABLE competition CHANGE categorie categorie INT NOT NULL, CHANGE complexe complexe INT NOT NULL');
        $this->addSql('ALTER TABLE equipe CHANGE capitain capitain INT NOT NULL');
        $this->addSql('ALTER TABLE invitation CHANGE utilisateur utilisateur INT NOT NULL');
        $this->addSql('ALTER TABLE matche ADD competition VARCHAR(50) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`');
        $this->addSql('ALTER TABLE niveau_competition CHANGE competition competition INT NOT NULL');
        $this->addSql('ALTER TABLE participation CHANGE competition competition INT NOT NULL, CHANGE equipe equipe INT NOT NULL');
        $this->addSql('ALTER TABLE penalite CHANGE complexe complexe INT NOT NULL');
        $this->addSql('ALTER TABLE penalite_joueur CHANGE arbitre arbitre INT NOT NULL, CHANGE joueur joueur INT NOT NULL, CHANGE matche matche INT NOT NULL, CHANGE penalite penalite INT NOT NULL');
        $this->addSql('ALTER TABLE reservation CHANGE heure heure TIME DEFAULT NULL, CHANGE validee validee TINYINT(1) DEFAULT \'0\', CHANGE montant montant DOUBLE PRECISION DEFAULT NULL, CHANGE acceptee acceptee TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE terrain CHANGE complexe complexe INT NOT NULL, CHANGE categorie categorie INT NOT NULL');
    }
}
