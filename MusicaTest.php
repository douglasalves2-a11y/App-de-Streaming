<?php

declare(strict_types=1);

namespace Streaming\Tests;

use PHPUnit\Framework\TestCase;
use Streaming\Musica;
use Streaming\Reproduzivel;
use Streaming\Midia;

/**
 * Testes para a classe Musica.
 */
class MusicaTest extends TestCase
{
    private Musica $musica;

    protected function setUp(): void
    {
        $this->musica = new Musica(
            titulo:          'Bohemian Rhapsody',
            autor:           'Queen',
            duracaoSegundos: 354,
            album:           'A Night at the Opera',
            genero:          'Rock Clássico',
        );
    }

    // ─── Herança e contratos ────────────────────────────────────────────────

    public function testMusicaEhUmaInstanciaDeMedia(): void
    {
        $this->assertInstanceOf(Midia::class, $this->musica);
    }

    public function testMusicaImplementaInterfaceReproduzivelDiretamente(): void
    {
        $this->assertInstanceOf(Reproduzivel::class, $this->musica);
    }

    // ─── Getters herdados de Midia ─────────────────────────────────────────

    public function testGetTituloRetornaTituloCorreto(): void
    {
        $this->assertSame('Bohemian Rhapsody', $this->musica->getTitulo());
    }

    public function testGetAutorRetornaAutorCorreto(): void
    {
        $this->assertSame('Queen', $this->musica->getAutor());
    }

    public function testGetDuracaoSegundosRetornaDuracaoCorreta(): void
    {
        $this->assertSame(354, $this->musica->getDuracaoSegundos());
    }

    // ─── Duração formatada ─────────────────────────────────────────────────

    public function testGetDuracaoFormatadaRetornaFormatoMinutosSegundos(): void
    {
        // 354s = 5min 54s → "05:54"
        $this->assertSame('05:54', $this->musica->getDuracaoFormatada());
    }

    public function testDuracaoFormatadaComSegundosExatos(): void
    {
        $musica = new Musica('Song', 'Artist', 60, 'Album', 'Pop');
        $this->assertSame('01:00', $musica->getDuracaoFormatada());
    }

    public function testDuracaoFormatadaComMaisDeUmaHora(): void
    {
        // 3661s = 61min 01s → "61:01"
        $musica = new Musica('Long Song', 'Artist', 3661, 'Album', 'Instrumental');
        $this->assertSame('61:01', $musica->getDuracaoFormatada());
    }

    public function testDuracaoFormatadaComZeroSegundos(): void
    {
        $musica = new Musica('Silence', 'Artist', 0, 'Album', 'Ambient');
        $this->assertSame('00:00', $musica->getDuracaoFormatada());
    }

    // ─── Getters próprios de Musica ────────────────────────────────────────

    public function testGetAlbumRetornaAlbumCorreto(): void
    {
        $this->assertSame('A Night at the Opera', $this->musica->getAlbum());
    }

    public function testGetGeneroRetornaGeneroCorreto(): void
    {
        $this->assertSame('Rock Clássico', $this->musica->getGenero());
    }

    // ─── Tipo ──────────────────────────────────────────────────────────────

    public function testGetTipoRetornaMusicaString(): void
    {
        $this->assertSame('Música', $this->musica->getTipo());
    }

    // ─── Reproduzir ────────────────────────────────────────────────────────

    public function testReproduzirRetornaStringNaoVazia(): void
    {
        $this->assertNotEmpty($this->musica->reproduzir());
    }

    public function testReproduzirContemTitulo(): void
    {
        $this->assertStringContainsString('Bohemian Rhapsody', $this->musica->reproduzir());
    }

    public function testReproduzirContemAutor(): void
    {
        $this->assertStringContainsString('Queen', $this->musica->reproduzir());
    }

    public function testReproduzirContemAlbum(): void
    {
        $this->assertStringContainsString('A Night at the Opera', $this->musica->reproduzir());
    }

    public function testReproduzirContemGenero(): void
    {
        $this->assertStringContainsString('Rock Clássico', $this->musica->reproduzir());
    }

    public function testReproduzirContemDuracaoFormatada(): void
    {
        $this->assertStringContainsString('05:54', $this->musica->reproduzir());
    }

    public function testReproduzirContemTipoMidia(): void
    {
        $this->assertStringContainsString('Música', $this->musica->reproduzir());
    }

    public function testReproduzirFormatoCompleto(): void
    {
        $saida = $this->musica->reproduzir();
        $this->assertStringContainsString('🎵', $saida);
        $this->assertStringContainsString('[Música]', $saida);
    }

    // ─── Diferentes instâncias ─────────────────────────────────────────────

    public function testMusicaComDadosDiferentes(): void
    {
        $outra = new Musica('Blinding Lights', 'The Weeknd', 200, 'After Hours', 'Synth-pop');
        $this->assertSame('Blinding Lights', $outra->getTitulo());
        $this->assertSame('The Weeknd', $outra->getAutor());
        $this->assertSame(200, $outra->getDuracaoSegundos());
        $this->assertSame('After Hours', $outra->getAlbum());
        $this->assertSame('Synth-pop', $outra->getGenero());
        $this->assertSame('03:20', $outra->getDuracaoFormatada());
    }
}
