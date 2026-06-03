<?php
require_once __DIR__ . '/../src/Reproduzivel.php';
require_once __DIR__ . '/../src/Midia.php';
require_once __DIR__ . '/../src/Musica.php';
require_once __DIR__ . '/../src/Podcast.php';
require_once __DIR__ . '/../src/VideoCurto.php';
require_once __DIR__ . '/../src/Playlist.php';


use Streaming\Musica;
use Streaming\Podcast;
use Streaming\VideoCurto;
use Streaming\Playlist;

$passou = 0;
$falhou = 0;

function ok(string $descricao, bool $condicao): void {
    global $passou, $falhou;
    if ($condicao) {
        echo "✅ $descricao\n";
        $passou++;
    } else {
        echo "❌ FALHOU: $descricao\n";
        $falhou++;
    }
}

echo "\n===== TESTES: Musica =====\n";
$musica = new Musica('Bohemian Rhapsody', 'Queen', 354, 'A Night at the Opera', 'Rock Clássico');
ok('getTitulo()', $musica->getTitulo() === 'Bohemian Rhapsody');
ok('getAutor()', $musica->getAutor() === 'Queen');
ok('getDuracaoSegundos()', $musica->getDuracaoSegundos() === 354);
ok('getDuracaoFormatada()', $musica->getDuracaoFormatada() === '05:54');
ok('getAlbum()', $musica->getAlbum() === 'A Night at the Opera');
ok('getGenero()', $musica->getGenero() === 'Rock Clássico');
ok('getTipo()', $musica->getTipo() === 'Música');
ok('reproduzir() contém título', str_contains($musica->reproduzir(), 'Bohemian Rhapsody'));
ok('reproduzir() contém autor', str_contains($musica->reproduzir(), 'Queen'));
ok('reproduzir() contém álbum', str_contains($musica->reproduzir(), 'A Night at the Opera'));

echo "\n===== TESTES: Podcast =====\n";
$podcast = new Podcast('IA no Futuro', 'Carlos', 3240, 'Tech Cast', 47, 'Sobre IA.');
ok('getTitulo()', $podcast->getTitulo() === 'IA no Futuro');
ok('getAutor()', $podcast->getAutor() === 'Carlos');
ok('getDuracaoSegundos()', $podcast->getDuracaoSegundos() === 3240);
ok('getDuracaoFormatada()', $podcast->getDuracaoFormatada() === '54:00');
ok('getPrograma()', $podcast->getPrograma() === 'Tech Cast');
ok('getEpisodio()', $podcast->getEpisodio() === 47);
ok('getDescricao()', $podcast->getDescricao() === 'Sobre IA.');
ok('getTipo()', $podcast->getTipo() === 'Podcast');
ok('reproduzir() contém título', str_contains($podcast->reproduzir(), 'IA no Futuro'));
ok('reproduzir() contém episódio', str_contains($podcast->reproduzir(), '47'));

echo "\n===== TESTES: VideoCurto =====\n";
$video = new VideoCurto('Bolo em 60s', 'cozinha_rapida', 60, 'TikTok', 452000, 'Culinária');
ok('getTitulo()', $video->getTitulo() === 'Bolo em 60s');
ok('getAutor()', $video->getAutor() === 'cozinha_rapida');
ok('getDuracaoSegundos()', $video->getDuracaoSegundos() === 60);
ok('getDuracaoFormatada()', $video->getDuracaoFormatada() === '01:00');
ok('getPlataforma()', $video->getPlataforma() === 'TikTok');
ok('getCurtidas()', $video->getCurtidas() === 452000);
ok('getCategoria()', $video->getCategoria() === 'Culinária');
ok('getTipo()', $video->getTipo() === 'Vídeo Curto');
ok('reproduzir() contém @autor', str_contains($video->reproduzir(), '@cozinha_rapida'));
ok('reproduzir() contém plataforma', str_contains($video->reproduzir(), 'TikTok'));

echo "\n===== TESTES: Playlist =====\n";
$playlist = new Playlist('Minha Playlist');
ok('getNome()', $playlist->getNome() === 'Minha Playlist');
ok('total() inicia em 0', $playlist->total() === 0);
ok('duracaoTotalSegundos() inicia em 0', $playlist->duracaoTotalSegundos() === 0);

$playlist->adicionar($musica);
ok('total() após adicionar 1 item', $playlist->total() === 1);
ok('duracaoTotalSegundos() após adicionar música', $playlist->duracaoTotalSegundos() === 354);

$playlist->adicionar($podcast);
ok('total() após adicionar 2 itens', $playlist->total() === 2);
ok('duracaoTotalSegundos() somada corretamente', $playlist->duracaoTotalSegundos() === 3594);

$playlist->adicionar($video);
ok('total() após adicionar 3 itens', $playlist->total() === 3);

$musicas = $playlist->filtrarPorTipo('Música');
ok('filtrarPorTipo() retorna só músicas', count($musicas) === 1);

$podcasts = $playlist->filtrarPorTipo('Podcast');
ok('filtrarPorTipo() retorna só podcasts', count($podcasts) === 1);

$videos = $playlist->filtrarPorTipo('Vídeo Curto');
ok('filtrarPorTipo() retorna só vídeos', count($videos) === 1);

$nada = $playlist->filtrarPorTipo('Filme');
ok('filtrarPorTipo() tipo inexistente retorna vazio', count($nada) === 0);

$playlist->remover(1);
ok('total() após remover 1 item', $playlist->total() === 2);

try {
    $playlist->remover(99);
    ok('remover() índice inválido lança exceção', false);
} catch (\OutOfRangeException $e) {
    ok('remover() índice inválido lança exceção', true);
}

echo "\n==============================\n";
echo "✅ Passou: $passou\n";
echo "❌ Falhou: $falhou\n";
echo "Total:    " . ($passou + $falhou) . "\n\n";