# App de Streaming
Atividade da matéria POO 
# 🎧 PHP Streaming — CLI Player

Aplicativo de linha de comando em PHP que simula uma plataforma de streaming com suporte a **Música**, **Podcast** e **Vídeo Curto**, utilizando os pilares da Orientação a Objetos.

---

## 📁 Estrutura do Projeto

```
streaming-php/
├── src/
│   ├── Interfaces/
│   │   └── Reproduzivel.php    # Interface com método reproduzir()
│   ├── Midias/
│   │   ├── Midia.php           # Classe abstrata base
│   │   ├── Musica.php          # Herda Midia
│   │   ├── Podcast.php         # Herda Midia
│   │   └── VideoCurto.php      # Herda Midia
│   └── Playlist.php            # Gerencia e reproduz coleção de mídias
├── autoload.php                # Autoloader manual (sem Composer)
├── index.php                   # Ponto de entrada / demonstração
└── README.md
```

---

## 🧱 Conceitos Aplicados

| Conceito | Onde é usado |
|---|---|
| **Classe Abstrata** | `Midia` — define atributos e comportamentos comuns; força subclasses a implementar `getTipo()` e `reproduzir()` |
| **Interface** | `Reproduzivel` — contrato com o método `reproduzir(): string` |
| **Herança** | `Musica`, `Podcast` e `VideoCurto` estendem `Midia` |
| **Polimorfismo** | `Playlist::reproduzirTodos()` chama `reproduzir()` em cada item sem saber o tipo concreto |
| **`declare(strict_types=1)`** | Em todos os arquivos PHP |
| **Atributos privados** | Todos os atributos são `private` (com `readonly`) |
| **Promotor de propriedades** | Usado nos construtores de todas as classes |
| **Tipagem adequada** | Parâmetros, retornos e propriedades todos tipados |

---

## ▶️ Como Executar

### Pré-requisito
- PHP **8.1** ou superior

### Rodar

```bash
php index.php
```

---

## 📌 Diagrama de Classes (simplificado)

```
             «interface»
            Reproduzivel
          reproduzir(): string
                 ▲
                 |
          ┌──────┴──────┐
          │  (abstrata)  │
          │    Midia     │
          │─────────────│
          │ -titulo      │
          │ -autor       │
          │ -duracao     │
          │─────────────│
          │ getTipo()    │
          │ reproduzir() │
          └──────┬───────┘
        ┌────────┼────────┐
        ▼        ▼        ▼
     Musica  Podcast  VideoCurto


           Playlist
          ──────────
          -midias[]
          ──────────
          adicionar()
          reproduzirTodos()
```

---

## 👥 Integrantes do Grupo

| # | Nome |
|---|------|
| 1 |      |
| 2 |      |
| 3 |      |
| 4 |      |
| 5 |      |

---

## 📄 Licença

Projeto acadêmico — uso educacional.
