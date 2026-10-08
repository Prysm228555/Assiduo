<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261007164518 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE appel (id INT AUTO_INCREMENT NOT NULL, date_appel DATE NOT NULL, horodatage_validation DATE DEFAULT NULL, verrouille TINYINT NOT NULL, creneau_id INT NOT NULL, INDEX IDX_130D3BD7D0729A9 (creneau_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE classe (id INT AUTO_INCREMENT NOT NULL, nom_classe VARCHAR(20) NOT NULL, niveau VARCHAR(20) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE creneau (id INT AUTO_INCREMENT NOT NULL, jour_semaine VARCHAR(20) NOT NULL, heure_debut TIME NOT NULL, heurefin TIME NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_F9668B5FFB88E14F (utilisateur_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE creneau_classe (creneau_id INT NOT NULL, classe_id INT NOT NULL, INDEX IDX_3A42FE907D0729A9 (creneau_id), INDEX IDX_3A42FE908F5EA509 (classe_id), PRIMARY KEY (creneau_id, classe_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE eleve (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) DEFAULT NULL, date_naissance DATE NOT NULL, classe_id INT NOT NULL, INDEX IDX_ECA105F78F5EA509 (classe_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE journal_audit (id INT AUTO_INCREMENT NOT NULL, date_heure DATE NOT NULL, action VARCHAR(255) NOT NULL, autorisee TINYINT NOT NULL, type_ressource VARCHAR(255) NOT NULL, id_ressource INT DEFAULT NULL, utilisateur_id INT NOT NULL, INDEX IDX_71C3CC53FB88E14F (utilisateur_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE presence (id INT AUTO_INCREMENT NOT NULL, status VARCHAR(50) NOT NULL, duree_retard INT DEFAULT NULL, justifie TINYINT NOT NULL, motif LONGTEXT DEFAULT NULL, date_qualification DATETIME DEFAULT NULL, appel_id INT NOT NULL, eleve_id INT NOT NULL, INDEX IDX_6977C7A5270B0E02 (appel_id), INDEX IDX_6977C7A5A6CC7B2 (eleve_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, nom_role VARCHAR(20) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) DEFAULT NULL, role_id INT NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), INDEX IDX_1D1C63B3D60322AC (role_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE appel ADD CONSTRAINT FK_130D3BD7D0729A9 FOREIGN KEY (creneau_id) REFERENCES creneau (id)');
        $this->addSql('ALTER TABLE creneau ADD CONSTRAINT FK_F9668B5FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE creneau_classe ADD CONSTRAINT FK_3A42FE907D0729A9 FOREIGN KEY (creneau_id) REFERENCES creneau (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE creneau_classe ADD CONSTRAINT FK_3A42FE908F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F78F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE journal_audit ADD CONSTRAINT FK_71C3CC53FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE presence ADD CONSTRAINT FK_6977C7A5270B0E02 FOREIGN KEY (appel_id) REFERENCES appel (id)');
        $this->addSql('ALTER TABLE presence ADD CONSTRAINT FK_6977C7A5A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appel DROP FOREIGN KEY FK_130D3BD7D0729A9');
        $this->addSql('ALTER TABLE creneau DROP FOREIGN KEY FK_F9668B5FFB88E14F');
        $this->addSql('ALTER TABLE creneau_classe DROP FOREIGN KEY FK_3A42FE907D0729A9');
        $this->addSql('ALTER TABLE creneau_classe DROP FOREIGN KEY FK_3A42FE908F5EA509');
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY FK_ECA105F78F5EA509');
        $this->addSql('ALTER TABLE journal_audit DROP FOREIGN KEY FK_71C3CC53FB88E14F');
        $this->addSql('ALTER TABLE presence DROP FOREIGN KEY FK_6977C7A5270B0E02');
        $this->addSql('ALTER TABLE presence DROP FOREIGN KEY FK_6977C7A5A6CC7B2');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3D60322AC');
        $this->addSql('DROP TABLE appel');
        $this->addSql('DROP TABLE classe');
        $this->addSql('DROP TABLE creneau');
        $this->addSql('DROP TABLE creneau_classe');
        $this->addSql('DROP TABLE eleve');
        $this->addSql('DROP TABLE journal_audit');
        $this->addSql('DROP TABLE presence');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE utilisateur');
    }
}
