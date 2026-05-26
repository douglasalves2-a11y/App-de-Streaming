<?php

declare(strict_types=1);

namespace Streaming;

class Playlist
{
    /** @var Midia[] */
    private array $midias = [];

    public function __construct(
        private string $nome,
    ) {}

    public function getNome(): string
    {
        return $this->nome;
    }

    public function adicionar(Midia $midia): void
    {
        $this->midias[] = $midia;
    }

    public function remover(int $indice): void
    {
        if (!isset($this->midias[$indice])) {
            throw new \OutOfRangeException("Índice $indice não encontrado na playlist.");
        }

        array_splice($this->midias, $indice, 1);
    }

    public function total(): int
    {
        return count($this->midias);
    }

    public function duracaoTotalSegundos(): int
    {
        return array_sum(
            array_map(fn(Midia $m) => $m->getDuracaoSegundos(), $this->midias)
        );
    }

    public function duracaoTotalFormatada(): string
    {
        $total   = $this->duracaoTotalSegundos();
        $horas   = intdiv($total, 3600);
        $minutos = intdiv($total % 3600, 60);
        $segundos = $total % 60;

        return $horas > 0
            ? sprintf('%dh %02dmin %02ds', $horas, $minutos, $segundos)
            : sprintf('%dmin %02ds', $minutos, $segundos);
    }

    public function reproduzirTodos(): void
    {
        $separador = str_repeat('─', 70);

        echo PHP_EOL;
        echo "╔" . str_repeat("═", 68) . "╗" . PHP_EOL;
        echo sprintf("║  ▶  Playlist: %-52s║", $this->nome) . PHP_EOL;
        echo sprintf("║     %d itens  │  Duração total: %-36s║", $this->total(), $this->duracaoTotalFormatada()) . PHP_EOL;
        echo "╚" . str_repeat("═", 68) . "╝" . PHP_EOL;
        echo PHP_EOL;

        if (empty($this->midias)) {
            echo "  ⚠️  A playlist está vazia." . PHP_EOL;
            return;
        }

        foreach ($this->midias as $indice => $midia) {
            $numero = $indice + 1;
            echo "  {$numero}. " . $midia->reproduzir() . PHP_EOL;
            echo "     $separador" . PHP_EOL;
        }

        echo PHP_EOL;
        echo "  ✅ Reprodução concluída! Total: {$this->total()} mídias — {$this->duracaoTotalFormatada()}" . PHP_EOL;
        echo PHP_EOL;
    }

    /**
     * Retorna apenas mídias de um tipo específico (ex: 'Música', 'Podcast', 'Vídeo Curto').
     * @return Midia[]
     */
    public function filtrarPorTipo(string $tipo): array
    {
        return array_values(
            array_filter($this->midias, fn(Midia $m) => $m->getTipo() === $tipo)
        );
    }
}
