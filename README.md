# Magnifica Humanitas (site estático)

Site estático, responsivo e leve para **magnificahumanitas.com.br**, desenvolvido com HTML, CSS e JavaScript puros.

## Estrutura

- `index.html` — página principal com seções institucionais.
- `assets/style.css` — estilos e responsividade.
- `assets/script.js` — menu mobile simples.
- `assets/magnificahumanitas.pdf` — opcional (adicionar manualmente quando disponível).

## Publicação rápida (cPanel / public_html)

1. Compacte os arquivos do projeto (ou envie por FTP).
2. No servidor, copie tudo para `public_html/` mantendo a pasta `assets/`.
3. Garanta que o arquivo principal esteja como `public_html/index.html`.
4. (Opcional) Envie o PDF da encíclica em `public_html/assets/magnificahumanitas.pdf`.

## Observações

- Não utiliza frameworks ou bibliotecas externas.
- Não possui dependências de build.
- O site declara explicitamente que **não é oficial da Santa Sé**.
- O link oficial do Vaticano está disponível no hero, na seção da Encíclica e no rodapé.
