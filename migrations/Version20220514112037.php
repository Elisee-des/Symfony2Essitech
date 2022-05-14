<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220514112037 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE absence ADD eleve_id INT NOT NULL');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C9A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id)');
        $this->addSql('CREATE INDEX IDX_765AE0C9A6CC7B2 ON absence (eleve_id)');
        $this->addSql('ALTER TABLE eleve ADD parent_id INT NOT NULL, ADD classe_id INT NOT NULL');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F7727ACA70 FOREIGN KEY (parent_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F78F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('CREATE INDEX IDX_ECA105F7727ACA70 ON eleve (parent_id)');
        $this->addSql('CREATE INDEX IDX_ECA105F78F5EA509 ON eleve (classe_id)');
        $this->addSql('ALTER TABLE message ADD user_id INT NOT NULL, ADD is_from_ecole TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FA76ED395 ON message (user_id)');
        $this->addSql('ALTER TABLE note ADD eleve_id INT NOT NULL');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA14A6CC7B2 ON note (eleve_id)');
        $this->addSql('ALTER TABLE retard ADD eleve_id INT NOT NULL');
        $this->addSql('ALTER TABLE retard ADD CONSTRAINT FK_5C64DDBDA6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id)');
        $this->addSql('CREATE INDEX IDX_5C64DDBDA6CC7B2 ON retard (eleve_id)');
        $this->addSql('ALTER TABLE user ADD is_actif TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C9A6CC7B2');
        $this->addSql('DROP INDEX IDX_765AE0C9A6CC7B2 ON absence');
        $this->addSql('ALTER TABLE absence DROP eleve_id');
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY FK_ECA105F7727ACA70');
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY FK_ECA105F78F5EA509');
        $this->addSql('DROP INDEX IDX_ECA105F7727ACA70 ON eleve');
        $this->addSql('DROP INDEX IDX_ECA105F78F5EA509 ON eleve');
        $this->addSql('ALTER TABLE eleve DROP parent_id, DROP classe_id');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FA76ED395');
        $this->addSql('DROP INDEX IDX_B6BD307FA76ED395 ON message');
        $this->addSql('ALTER TABLE message DROP user_id, DROP is_from_ecole');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14A6CC7B2');
        $this->addSql('DROP INDEX IDX_CFBDFA14A6CC7B2 ON note');
        $this->addSql('ALTER TABLE note DROP eleve_id');
        $this->addSql('ALTER TABLE retard DROP FOREIGN KEY FK_5C64DDBDA6CC7B2');
        $this->addSql('DROP INDEX IDX_5C64DDBDA6CC7B2 ON retard');
        $this->addSql('ALTER TABLE retard DROP eleve_id');
        $this->addSql('ALTER TABLE `user` DROP is_actif');
    }
}
