<?php

declare(strict_types=1);

namespace Streaming\Tests;

use PHPUnit\Framework\TestCase;
use Streaming\VideoCurto;
use Streaming\Reproduzivel;
use Streaming\Midia;

/**
 * Testes para a classe VideoCurto.
 */
class VideoCurtoTest extends TestCase
{
    private VideoCurto $video;

    protected function setUp(): void
    {
        $this->video = new VideoCurto(
            titulo:          'Receita de Bolo de Cenoura em 60s',
            autor:           'cozinha_rapida',
            duracaoSegundos: 60,
            plataforma:      'TikTok',
            curtidas:        452000,
            categoria:       'Culinária',
        );
    }

    // ─── Herança e contratos ────────────────────────────────────────────────

    public function testVideoCurtoEhInstanciaDeMedia(): void
    {
        $this->assertInstanceOf(Midia::class, $this->video);
    }

    public function testVideoCurtoImplementaInterfaceReproduzivel(): void
    {
        $this->assertInstanceOf(Reproduzivel::class, $this->video);
    }

    // ─── Getters herdados ──────────────────────────────────────────────────

    public function testGetTituloRetornaTituloCorreto(): void
    {
        $this->assertSame('Receita de Bolo de Cenoura em 60s', $this->video->getTitulo());
    }

    public function testGetAutorRetornaAutorCorreto(): void
    {
        $this->assertSame('cozinha_rapida', $this->video->getAutor());
    }

    public function testGetDuracaoSegundosRetorna60(): void
    {
        $this->assertSame(60, $this->video->getDuracaoSegundos());
    }

    // ─── Duração formatada ─────────────────────────────────────────────────

    public function testGetDuracaoFormatadaRetormaUmMinuto(): void
    {
        $this->assertSame('01:00', $this->video->getDuracaoFormatada());
    }

    public function testDuracaoFormatadaComVideoMuitoCurto(): void
    {
        $v = new VideoCurto('Short', '@user', 15, 'Instagram', 100, 'Fun');
        $this->assertSame('00:15', $v->getDuracaoFormatada());
    }

    public function testDuracaoFormatadaCom90Segundos(): void
    {
        $v = new VideoCurto('Title', '@user', 90, 'YouTube', 0, 'Educação');
        $this->assertSame('01:30', $v->getDuracaoFormatada());
    }

    // ─── Getters próprios de VideoCurto ───────────────────────────────────

    public function testGetPlataformaRetornaPlataformaCorreta(): void
    {
        $this->assertSame('TikTok', $this->video->getPlataforma());
    }

    public function testGetCurtidasRetornaQuantidadeCorreta(): void
    {
        $this->assertSame(452000, $this->video->getCurtidas());
    }

    public function testGetCategoriaRetornaCategoriaCorreta(): void
    {
        $this->assertSame('Culinária', $this->video->getCategoria());
    }

    public function testCurtidasEhTipoInteiro(): void
    {
        $this->assertIsInt($this->video->getCurtidas());
    }

    // ─── Tipo ──────────────────────────────────────────────────────────────

    public function testGetTipoRetornaVideoCurtoString(): void
    {
        $this->assertSame('Vídeo Curto', $this->video->getTipo());
    }

    // ─── Reproduzir ────────────────────────────────────────────────────────

    public function testReproduzirRetornaStringNaoVazia(): void
    {
        $this->assertNotEmpty($this->video->reproduzir());
    }

    public function testReproduzirContemTitulo(): void
    {
        $this->assertStringContainsString('Receita de Bolo de Cenoura em 60s', $this->video->reproduzir());
    }

    public function testReproduzirContemAutorComArroba(): void
    {
        $this->assertStringContainsString('@cozinha_rapida', $this->video->reproduzir());
    }

    public function testReproduzirContemPlataforma(): void
    {
        $this->assertStringContainsString('TikTok', $this->video->reproduzir());
    }

    public function testReproduzirContemCategoria(): void
    {
        $this->assertStringContainsString('Culinária', $this->video->reproduzir());
    }

    public function testReproduzirContemCurtidasFormatadas(): void
    {
        // 452000 formatado em pt_BR → "452.000"
        $saida = $this->video->reproduzir();
        $this->assertStringContainsString('452', $saida);
        $this->assertStringContainsString('curtidas', $saida);
    }

    public function testReproduzirContemDuracaoFormatada(): void
    {
        $this->assertStringContainsString('01:00', $this->video->reproduzir());
    }

    public function testReproduzirContemIconeELabel(): void
    {
        $saida = $this->video->reproduzir();
        $this->assertStringContainsString('📱', $saida);
        $this->assertStringContainsString('[Vídeo Curto]', $saida);
        $this->assertStringContainsString('❤️', $saida);
    }

    // ─── Curtidas zero ────────────────────────────────────────────────────

    public function testVideoCurtoComCurtidasZero(): void
    {
        $v = new VideoCurto('New Video', '@novo', 30, 'TikTok', 0, 'Diversos');
        $this->assertSame(0, $v->getCurtidas());
        $this->assertStringContainsString('0', $v->reproduzir());
    }

    // ─── Diferentes plataformas ───────────────────────────────────────────

    /**
     * @dataProvider plataformasProvider
     */
    public function testVideoCurtoComDiferentesPlataformas(string $plataforma): void
    {
        $v = new VideoCurto('Test', '@user', 30, $plataforma, 100, 'Geral');
        $this->assertSame($plataforma, $v->getPlataforma());
        $this->assertStringContainsString($plataforma, $v->reproduzir());
    }

    public static function plataformasProvider(): array
    {
        return [
            ['TikTok'],
            ['YouTube'],
            ['Instagram'],
            ['Twitter'],
        ];
    }
}
