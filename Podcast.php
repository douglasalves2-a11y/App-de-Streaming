<?php

declare(strict_types=1);

namespace Streaming;

class Podcast extends Midia
{
    public function __construct(
        string         $titulo,
        string         $autor,
        int            $duracaoSegundos,
        private string $programa,
        private int    $episodio,
        private string $descricao,
    ) {
        parent::__construct($titulo, $autor, $duracaoSegundos);
    }

    public function getPrograma(): string
    {
        return $this->programa;
    }

    public function getEpisodio(): int
    {
        return $this->episodio;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function getTipo(): string
    {
        return 'Podcast';
    }

    public function reproduzir(): string
    {
        return sprintf(
            "🎙️ [%s] Reproduzindo: \"%s\" — %s | Programa: %s | Ep. %d | Duração: %s\n   📝 %s",
            $this->getTipo(),
            $this->getTitulo(),
            $this->getAutor(),
            $this->programa,
            $this->episodio,
            $this->getDuracaoFormatada(),
            $this->descricao,
        );
    }
}
