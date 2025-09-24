<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250924213509 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE libro (id INT AUTO_INCREMENT NOT NULL, titulo VARCHAR(50) NOT NULL, autor VARCHAR(50) NOT NULL, genero VARCHAR(50) NOT NULL, descripcion VARCHAR(255) NOT NULL, imagen VARCHAR(255) NOT NULL, estado VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reserva (id INT AUTO_INCREMENT NOT NULL, socio_id INT NOT NULL, libro_id INT NOT NULL, fecha_inicio DATE NOT NULL, fecha_fin DATE NOT NULL, estado VARCHAR(50) NOT NULL, INDEX IDX_188D2E3BDA04E6A9 (socio_id), INDEX IDX_188D2E3BC0238522 (libro_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE validacion (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, tipo VARCHAR(50) NOT NULL, fecha DATE NOT NULL, estado VARCHAR(50) NOT NULL, observaciones VARCHAR(255) NOT NULL, INDEX IDX_DB623448DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3BDA04E6A9 FOREIGN KEY (socio_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3BC0238522 FOREIGN KEY (libro_id) REFERENCES libro (id)');
        $this->addSql('ALTER TABLE validacion ADD CONSTRAINT FK_DB623448DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reserva DROP FOREIGN KEY FK_188D2E3BDA04E6A9');
        $this->addSql('ALTER TABLE reserva DROP FOREIGN KEY FK_188D2E3BC0238522');
        $this->addSql('ALTER TABLE validacion DROP FOREIGN KEY FK_DB623448DB38439E');
        $this->addSql('DROP TABLE libro');
        $this->addSql('DROP TABLE reserva');
        $this->addSql('DROP TABLE validacion');
    }
}
