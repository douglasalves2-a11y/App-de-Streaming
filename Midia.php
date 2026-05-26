<?php

declare(strict_types=1);

namespace Streaming;

abstract class Midia implements Reproduzivel
{
    public function __construct(
        private string $titulo,
        private string $autor,
        private int    $duracaoSegundos,
    ) {}

    public function getTitulo(): string
    {
        return $this->titulo;
    }

    public function getAutor(): string
    {
        return $this->autor;
    }

    public function getDuracaoSegundos(): int
    {
        return $this->duracaoSegundos;
    }

    public function getDuracaoFormatada(): string
    {
        $minutos = intdiv($this->duracaoSegundos, 60);
        $segundos = $this->duracaoSegundos % 60;
        return sprintf('%02d:%02d', $minutos, $segundos);
    }

    abstract public function getTipo(): string;

    abstract public function reproduzir(): string;
}
