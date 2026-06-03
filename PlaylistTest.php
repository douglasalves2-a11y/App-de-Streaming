<?php

declare(strict_types=1);

namespace Streaming\Tests;

use OutOfRangeException;
use PHPUnit\Framework\TestCase;
use Streaming\Musica;
use Streaming\Playlist;
use Streaming\Podcast;
use Streaming\VideoCurto;

/**
 * Testes para a classe Playlist.
 */
class PlaylistTest extends TestCase
{
    private Playlist $playlist;

    private Musica $musica1;
    private Musica $musica2;
    private Podcast $podcast;
    private VideoCurto $video;

    protected function setUp(): void
    {
        $this->playlist = new Playlist('Minha Playlist de Testes');

        $this->musica1 = new Musica('Bohemian Rhapsody', 'Queen', 354, 'A Night at the Opera', 'Rock Clássico');
        $this->musica2 = new Musica('Blinding Lights', 'The Weeknd', 200, 'After Hours', 'Synth-pop');
        $this->podcast = new Podcast('EP01', 'Host', 1800, 'Programa', 1, 'Descrição.');
        $this->video   = new VideoCurto('Video Legal', '@creator', 60, 'TikTok', 5000, 'Entretenimento');
    }

    // ─── getNome ──────────────────────────────────────────────────────────

    public function testGetNomeRetornaNomeCorreto(): void
    {
        $this->assertSame('Minha Playlist de Testes', $this->playlist->getNome());
    }

    public function testPlaylistComNomeVazio(): void
    {
        $p = new Playlist('');
        $this->assertSame('', $p->getNome());
    }

    // ─── total (playlist vazia) ───────────────────────────────────────────

    public function testTotalIniciaEmZero(): void
    {
        $this->assertSame(0, $this->playlist->total());
    }

    public function testDuracaoTotalSegundosIniciaEmZero(): void
    {
        $this->assertSame(0, $this->playlist->duracaoTotalSegundos());
    }

    // ─── adicionar ────────────────────────────────────────────────────────

    public function testAdicionarUmItemAumentaTotalParaUm(): void
    {
        $this->playlist->adicionar($this->musica1);
        $this->assertSame(1, $this->playlist->total());
    }

    public function testAdicionarDoisItensAumentaTotalParaDois(): void
    {
        $this->playlist->adicionar($this->musica1);
        $this->playlist->adicionar($this->musica2);
        $this->assertSame(2, $this->playlist->total());
    }

    public function testAdicionarMidiasDeTiposDiferentes(): void
    {
        $this->playlist->adicionar($this->musica1);
        $this->playlist->adicionar($this->podcast);
        $this->playlist->adicionar($this->video);
        $this->assertSame(3, $this->playlist->total());
    }

    public function testAdicionarMesmaMidiaduasVezesAumentaTotalParaDois(): void
    {
        $this->playlist->adicionar($this->musica1);
        $this->playlist->adicionar($this->musica1);
        $this->assertSame(2, $this->playlist->total());
    }

    // ─── duracaoTotalSegundos ────────────────────────────────────────────

    public function testDuracaoTotalComUmaMusica(): void
    {
        $this->playlist->adicionar($this->musica1);
        $this->assertSame(354, $this->playlist->duracaoTotalSegundos());
    }

    public function testDuracaoTotalComDuasMusicasSomaDuracoes(): void
    {
        $this->playlist->adicionar($this->musica1); // 354s
        $this->playlist->adicionar($this->musica2); // 200s
        $this->assertSame(554, $this->playlist->duracaoTotalSegundos());
    }

    public function testDuracaoTotalComTiposMistos(): void
    {
        $this->playlist->adicionar($this->musica1); // 354s
        $this->playlist->adicionar($this->podcast); // 1800s
        $this->playlist->adicionar($this->video);   // 60s
        $this->assertSame(2214, $this->playlist->duracaoTotalSegundos());
    }

    // ─── duracaoTotalFormatada ────────────────────────────────────────────

    public function testDuracaoTotalFormatadaPlaylistVazia(): void
    {
        $this->assertSame('0min 00s', $this->playlist->duracaoTotalFormatada());
    }

    public function testDuracaoTotalFormatadaAbaixoDeUmaHora(): void
    {
        $this->playlist->adicionar($this->musica1); // 354s = 5min 54s
        $this->assertSame('5min 54s', $this->playlist->duracaoTotalFormatada());
    }

    public function testDuracaoTotalFormatadaAcimaDeUmaHora(): void
    {
        // Adiciona 3660s = 1h 1min 0s
        $m = new Musica('Long', 'Artist', 3660, 'Album', 'Genre');
        $this->playlist->adicionar($m);
        $this->assertSame('1h 01min 00s', $this->playlist->duracaoTotalFormatada());
    }

    public function testDuracaoTotalFormatadaComExatamenteUmaHora(): void
    {
        $m = new Musica('Exact', 'Artist', 3600, 'Album', 'Genre');
        $this->playlist->adicionar($m);
        $this->assertSame('1h 00min 00s', $this->playlist->duracaoTotalFormatada());
    }

    public function testDuracaoTotalFormatadaComMultiplasHoras(): void
    {
        $m = new Musica('Very Long', 'Artist', 7384, 'Album', 'Genre'); // 2h 3min 4s
        $this->playlist->adicionar($m);
        $this->assertSame('2h 03min 04s', $this->playlist->duracaoTotalFormatada());
    }

    // ─── remover ──────────────────────────────────────────────────────────

    public function testRemoverItemDiminuiTotalParaZero(): void
    {
        $this->playlist->adicionar($this->musica1);
        $this->playlist->remover(0);
        $this->assertSame(0, $this->playlist->total());
    }

    public function testRemoverItemDoMeioReindexaCorretamente(): void
    {
        $this->playlist->adicionar($this->musica1); // índice 0
        $this->playlist->adicionar($this->podcast); // índice 1
        $this->playlist->adicionar($this->musica2); // índice 2

        $this->playlist->remover(1); // remove podcast

        $this->assertSame(2, $this->playlist->total());
        // Duração restante: 354 + 200 = 554
        $this->assertSame(554, $this->playlist->duracaoTotalSegundos());
    }

    public function testRemoverUltimoItemDaPlaylist(): void
    {
        $this->playlist->adicionar($this->musica1);
        $this->playlist->adicionar($this->musica2);
        $this->playlist->remover(1);
        $this->assertSame(1, $this->playlist->total());
        $this->assertSame(354, $this->playlist->duracaoTotalSegundos());
    }

    public function testRemoverIndiceInexistentelancaExcecao(): void
    {
        $this->expectException(OutOfRangeException::class);
        $this->playlist->remover(0);
    }

    public function testRemoverIndiceNegativoLancaExcecao(): void
    {
        $this->playlist->adicionar($this->musica1);
        $this->expectException(OutOfRangeException::class);
        $this->playlist->remover(-1);
    }

    public function testRemoverIndiceMaiorQueUltimoLancaExcecao(): void
    {
        $this->playlist->adicionar($this->musica1); // apenas índice 0
        $this->expectException(OutOfRangeException::class);
        $this->playlist->remover(5);
    }

    public function testMensagemExcecaoContemIndice(): void
    {
        $this->expectException(OutOfRangeException::class);
        $this->expectExceptionMessageMatches('/99/');
        $this->playlist->remover(99);
    }

    // ─── filtrarPorTipo ───────────────────────────────────────────────────

    public function testFiltrarPorTipoMusicaRetornaApenasMusicas(): void
    {
        $this->playlist->adicionar($this->musica1);
        $this->playlist->adicionar($this->podcast);
        $this->playlist->adicionar($this->video);
        $this->playlist->adicionar($this->musica2);

        $musicas = $this->playlist->filtrarPorTipo('Música');

        $this->assertCount(2, $musicas);
        foreach ($musicas as $m) {
            $this->assertSame('Música', $m->getTipo());
        }
    }

    public function testFiltrarPorTipoPodcastRetornaApenasPodcasts(): void
    {
        $this->playlist->adicionar($this->musica1);
        $this->playlist->adicionar($this->podcast);
        $this->playlist->adicionar($this->video);

        $podcasts = $this->playlist->filtrarPorTipo('Podcast');

        $this->assertCount(1, $podcasts);
        $this->assertSame('Podcast', $podcasts[0]->getTipo());
    }

    public function testFiltrarPorTipoVideoCurtoRetornaApenasVideos(): void
    {
        $this->playlist->adicionar($this->musica1);
        $this->playlist->adicionar($this->video);

        $videos = $this->playlist->filtrarPorTipo('Vídeo Curto');

        $this->assertCount(1, $videos);
        $this->assertSame('Vídeo Curto', $videos[0]->getTipo());
    }

    public function testFiltrarPorTipoInexistenteRetornaArrayVazio(): void
    {
        $this->playlist->adicionar($this->musica1);
        $resultado = $this->playlist->filtrarPorTipo('Filme');
        $this->assertEmpty($resultado);
    }

    public function testFiltrarPorTipoEmPlaylistVaziaRetornaArrayVazio(): void
    {
        $resultado = $this->playlist->filtrarPorTipo('Música');
        $this->assertEmpty($resultado);
    }

    public function testFiltrarPorTipoRetornaArrayReindexado(): void
    {
        $this->playlist->adicionar($this->musica1);
        $this->playlist->adicionar($this->podcast);
        $this->playlist->adicionar($this->musica2);

        $musicas = $this->playlist->filtrarPorTipo('Música');

        // array_values garante índices 0 e 1
        $this->assertArrayHasKey(0, $musicas);
        $this->assertArrayHasKey(1, $musicas);
    }

    // ─── reproduzirTodos (saída em buffer) ────────────────────────────────

    public function testReproduzirTodosPlaylistVaziaExibeAviso(): void
    {
        ob_start();
        $this->playlist->reproduzirTodos();
        $saida = ob_get_clean();

        $this->assertStringContainsString('vazia', $saida);
    }

    public function testReproduzirTodosExibeNomeDaPlaylist(): void
    {
        $this->playlist->adicionar($this->musica1);
        ob_start();
        $this->playlist->reproduzirTodos();
        $saida = ob_get_clean();

        $this->assertStringContainsString('Minha Playlist de Testes', $saida);
    }

    public function testReproduzirTodosExibeTotalDeMidias(): void
    {
        $this->playlist->adicionar($this->musica1);
        $this->playlist->adicionar($this->musica2);
        ob_start();
        $this->playlist->reproduzirTodos();
        $saida = ob_get_clean();

        $this->assertStringContainsString('2', $saida);
    }

    public function testReproduzirTodosExibeTodasAsMidias(): void
    {
        $this->playlist->adicionar($this->musica1);
        $this->playlist->adicionar($this->podcast);

        ob_start();
        $this->playlist->reproduzirTodos();
        $saida = ob_get_clean();

        $this->assertStringContainsString('Bohemian Rhapsody', $saida);
        $this->assertStringContainsString('EP01', $saida);
    }
}
