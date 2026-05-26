<?php

declare(strict_types=1);

namespace Streaming;

class Musica extends Midia
{
    public function __construct(
        string         $titulo,
        string         $autor,
        int            $duracaoSegundos,
        private string $album,
        private string $genero,
    ) {
        parent::__construct($titulo, $autor, $duracaoSegundos);
    }

    public function getAlbum(): string
    {
        return $this->album;
    }

    public function getGenero(): string
    {
        return $this->genero;
    }

    public function getTipo(): string
    {
        return 'Música';
    }

    public function reproduzir(): string
    {
        return sprintf(
            "🎵 [%s] Tocando: \"%s\" — %s | Álbum: %s | Gênero: %s | Duração: %s",
            $this->getTipo(),
            $this->getTitulo(),
            $this->getAutor(),
            $this->album,
            $this->genero,
            $this->getDuracaoFormatada(),
        );
    }
}
