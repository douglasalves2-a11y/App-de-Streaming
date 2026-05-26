<?php

declare(strict_types=1);

namespace Streaming;

class VideoCurto extends Midia
{
    public function __construct(
        string         $titulo,
        string         $autor,
        int            $duracaoSegundos,
        private string $plataforma,
        private int    $curtidas,
        private string $categoria,
    ) {
        parent::__construct($titulo, $autor, $duracaoSegundos);
    }

    public function getPlataforma(): string
    {
        return $this->plataforma;
    }

    public function getCurtidas(): int
    {
        return $this->curtidas;
    }

    public function getCategoria(): string
    {
        return $this->categoria;
    }

    public function getTipo(): string
    {
        return 'Vídeo Curto';
    }

    public function reproduzir(): string
    {
        return sprintf(
            "📱 [%s] Assistindo: \"%s\" — @%s | Plataforma: %s | Categoria: %s | ❤️ %s curtidas | Duração: %s",
            $this->getTipo(),
            $this->getTitulo(),
            $this->getAutor(),
            $this->plataforma,
            $this->categoria,
            number_format($this->curtidas, 0, ',', '.'),
            $this->getDuracaoFormatada(),
        );
    }
}
