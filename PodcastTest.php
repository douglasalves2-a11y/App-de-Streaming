<?php

declare(strict_types=1);

namespace Streaming\Tests;

use PHPUnit\Framework\TestCase;
use Streaming\Podcast;
use Streaming\Reproduzivel;
use Streaming\Midia;

/**
 * Testes para a classe Podcast.
 */
class PodcastTest extends TestCase
{
    private Podcast $podcast;

    protected function setUp(): void
    {
        $this->podcast = new Podcast(
            titulo:          'O Futuro da Inteligência Artificial',
            autor:           'Carlos Pereira',
            duracaoSegundos: 3240,
            programa:        'Tecnologia Sem Filtro',
            episodio:        47,
            descricao:       'IA generativa, LLMs e o impacto no mercado de trabalho.',
        );
    }

    // ─── Herança e contratos ────────────────────────────────────────────────

    public function testPodcastEhInstanciaDeMedia(): void
    {
        $this->assertInstanceOf(Midia::class, $this->podcast);
    }

    public function testPodcastImplementaInterfaceReproduzivel(): void
    {
        $this->assertInstanceOf(Reproduzivel::class, $this->podcast);
    }

    // ─── Getters herdados ──────────────────────────────────────────────────

    public function testGetTituloRetornaTituloCorreto(): void
    {
        $this->assertSame('O Futuro da Inteligência Artificial', $this->podcast->getTitulo());
    }

    public function testGetAutorRetornaAutorCorreto(): void
    {
        $this->assertSame('Carlos Pereira', $this->podcast->getAutor());
    }

    public function testGetDuracaoSegundosRetornaDuracaoCorreta(): void
    {
        $this->assertSame(3240, $this->podcast->getDuracaoSegundos());
    }

    // ─── Duração formatada ─────────────────────────────────────────────────

    public function testGetDuracaoFormatadaRetormaFormatoCorreto(): void
    {
        // 3240s = 54min 00s → "54:00"
        $this->assertSame('54:00', $this->podcast->getDuracaoFormatada());
    }

    public function testDuracaoFormatadaComSegundosRestantes(): void
    {
        $podcast = new Podcast('Ep', 'A', 2700, 'Prog', 1, 'Desc');
        // 2700s = 45min 00s
        $this->assertSame('45:00', $podcast->getDuracaoFormatada());
    }

    // ─── Getters próprios do Podcast ──────────────────────────────────────

    public function testGetProgramaRetornaProgramaCorreto(): void
    {
        $this->assertSame('Tecnologia Sem Filtro', $this->podcast->getPrograma());
    }

    public function testGetEpisodioRetornaNumeroCorreto(): void
    {
        $this->assertSame(47, $this->podcast->getEpisodio());
    }

    public function testGetDescricaoRetornaDescricaoCorreta(): void
    {
        $this->assertSame(
            'IA generativa, LLMs e o impacto no mercado de trabalho.',
            $this->podcast->getDescricao()
        );
    }

    public function testEpisodioEhTipoInteiro(): void
    {
        $this->assertIsInt($this->podcast->getEpisodio());
    }

    // ─── Tipo ──────────────────────────────────────────────────────────────

    public function testGetTipoRetornaPodcastString(): void
    {
        $this->assertSame('Podcast', $this->podcast->getTipo());
    }

    // ─── Reproduzir ────────────────────────────────────────────────────────

    public function testReproduzirRetornaStringNaoVazia(): void
    {
        $this->assertNotEmpty($this->podcast->reproduzir());
    }

    public function testReproduzirContemTitulo(): void
    {
        $this->assertStringContainsString('O Futuro da Inteligência Artificial', $this->podcast->reproduzir());
    }

    public function testReproduzirContemAutor(): void
    {
        $this->assertStringContainsString('Carlos Pereira', $this->podcast->reproduzir());
    }

    public function testReproduzirContemPrograma(): void
    {
        $this->assertStringContainsString('Tecnologia Sem Filtro', $this->podcast->reproduzir());
    }

    public function testReproduzirContemNumeroEpisodio(): void
    {
        $this->assertStringContainsString('47', $this->podcast->reproduzir());
    }

    public function testReproduzirContemDescricao(): void
    {
        $this->assertStringContainsString('IA generativa', $this->podcast->reproduzir());
    }

    public function testReproduzirContemDuracaoFormatada(): void
    {
        $this->assertStringContainsString('54:00', $this->podcast->reproduzir());
    }

    public function testReproduzirContemIconeELabelCorretos(): void
    {
        $saida = $this->podcast->reproduzir();
        $this->assertStringContainsString('🎙️', $saida);
        $this->assertStringContainsString('[Podcast]', $saida);
        $this->assertStringContainsString('📝', $saida);
    }

    // ─── Episódio de valor diferente ──────────────────────────────────────

    public function testPodcastComEpisodioUm(): void
    {
        $pod = new Podcast('Estreia', 'Host', 600, 'Programa', 1, 'Episódio piloto.');
        $this->assertSame(1, $pod->getEpisodio());
        $this->assertStringContainsString('Ep. 1', $pod->reproduzir());
    }
}
