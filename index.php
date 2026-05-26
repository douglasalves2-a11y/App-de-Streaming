<?php
declare(strict_types=1);

require_once __DIR__ . '/src/Reproduzivel.php';
require_once __DIR__ . '/src/Midia.php';
require_once __DIR__ . '/src/Musica.php';
require_once __DIR__ . '/src/Podcast.php';
require_once __DIR__ . '/src/VideoCurto.php';
require_once __DIR__ . '/src/Playlist.php';

use Streaming\Musica;
use Streaming\Podcast;
use Streaming\Playlist;
use Streaming\VideoCurto;

// ─── Criação das mídias ──────────────────────────────────────────────────────

$musicas = [
    new Musica('Bohemian Rhapsody',    'Queen',           354, 'A Night at the Opera', 'Rock Clássico'),
    new Musica('Blinding Lights',      'The Weeknd',      200, 'After Hours',           'Synth-pop'),
    new Musica('Como Nossos Pais',     'Elis Regina',     223, 'Falso Brilhante',       'MPB'),
];

$podcasts = [
    new Podcast(
        titulo:           'O Futuro da Inteligência Artificial',
        autor:            'Carlos Pereira',
        duracaoSegundos:  3240,
        programa:         'Tecnologia Sem Filtro',
        episodio:         47,
        descricao:        'IA generativa, LLMs e o impacto no mercado de trabalho.',
    ),
    new Podcast(
        titulo:           'Como Investir com Pouco Dinheiro',
        autor:            'Ana Souza',
        duracaoSegundos:  2700,
        programa:         'Dinheiro em Dia',
        episodio:         12,
        descricao:        'Tesouro Direto, CDBs e fundos de investimento para iniciantes.',
    ),
];

$videos = [
    new VideoCurto('Receita de Bolo de Cenoura em 60s', 'cozinha_rapida', 60,  'TikTok',    452_000, 'Culinária'),
    new VideoCurto('10 Dicas de PHP Moderno',            'dev_tips',       90,  'YouTube',   198_300, 'Tecnologia'),
    new VideoCurto('Pôr do Sol em Timelapse',            'natureza_br',    45,  'Instagram',  87_500, 'Natureza'),
];

// ─── Montagem da Playlist ────────────────────────────────────────────────────

$playlist = new Playlist('🎧 Minha Playlist Variada');

foreach ($musicas as $m)  { $playlist->adicionar($m); }
foreach ($podcasts as $p) { $playlist->adicionar($p); }
foreach ($videos as $v)   { $playlist->adicionar($v); }

// ─── Reprodução completa (polimorfismo) ──────────────────────────────────────

$playlist->reproduzirTodos();

// ─── Demonstração do filtro por tipo ────────────────────────────────────────

echo "──────────────────────────────────────────────────────────────────────" . PHP_EOL;
echo "  🔍 Apenas Podcasts na playlist:" . PHP_EOL;
echo "──────────────────────────────────────────────────────────────────────" . PHP_EOL . PHP_EOL;

$soPodcasts = $playlist->filtrarPorTipo('Podcast');

foreach ($soPodcasts as $i => $pod) {
    echo "  " . ($i + 1) . ". " . $pod->reproduzir() . PHP_EOL;
}

echo PHP_EOL;
