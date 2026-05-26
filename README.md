# 🎧 StreamingPHP — Simulador de Playlist de Mídias

Projeto desenvolvido em PHP como trabalho acadêmico, simulando uma plataforma de streaming com suporte a **músicas**, **podcasts** e **vídeos curtos**, utilizando os princípios de **herança**, **interfaces** e **polimorfismo**.

---

## 📁 Estrutura do Projeto

```
streaming/
├── index.php               # Ponto de entrada / demonstração
└── src/
    ├── Reproduzivel.php    # Interface principal
    ├── Midia.php           # Classe abstrata base
    ├── Musica.php          # Classe filha — Música
    ├── Podcast.php         # Classe filha — Podcast
    ├── VideoCurto.php      # Classe filha — Vídeo Curto
    └── Playlist.php        # Gerenciador de playlist
```

---

## 🧱 Conceitos Aplicados

| Conceito | Onde é usado |
|---|---|
| **Interface** | `Reproduzivel` — contrato com o método `reproduzir(): string` |
| **Classe Abstrata** | `Midia` — atributos e comportamentos comuns a todas as mídias |
| **Herança** | `Musica`, `Podcast` e `VideoCurto` estendem `Midia` |
| **Polimorfismo** | `Playlist::reproduzirTodos()` chama `reproduzir()` em qualquer `Midia` |
| **`declare(strict_types=1)`** | Em todos os arquivos PHP |
| **Atributos privados** | Todos os atributos são `private` |
| **Property Promotion** | Construtores usam promoção de propriedades (`private string $x`) |
| **Tipagem adequada** | Todos os parâmetros e retornos são tipados |

---

## ▶️ Como Executar

**Requisito:** PHP 8.1 ou superior.

```bash
php index.php
```

---

## 📐 Diagrama de Classes (resumido)

```
«interface»
Reproduzivel
  + reproduzir(): string
       △
       │
«abstract»
Midia (implements Reproduzivel)
  - titulo: string
  - autor: string
  - duracaoSegundos: int
  + getTipo(): string  «abstract»
  + reproduzir(): string  «abstract»
  + getDuracaoFormatada(): string
    /    |    \
   /     |     \
Musica Podcast VideoCurto
```

---

## 👥 Integrantes

- Integrante David Sergio Finoti
- Integrante Ryan Evaristo
- Integrante Marco Tulio Reis de Andrande
- Integrante Dilermando Lourenço
- Integrante Douglas Henrique
