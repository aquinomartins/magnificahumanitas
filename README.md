# Magnifica Humanitas

Landing page institucional/cultural da plataforma **Magnifica Humanitas**.

## 1) Publicação no `public_html`
1. Copie todos os arquivos e pastas deste projeto para `public_html`.
2. Mantenha a estrutura:
   - `index.html`
   - `subscribe.php`
   - `metrics.php`
   - `assets/`
   - `admin/`
   - `data/`

## 2) Imagem licenciada da Capela Sistina
- Coloque a imagem em: `assets/img/capela-sistina-hero.jpg`.
- **Importante:** use apenas imagem com licenciamento adequado para uso no site.

## 3) PDF da Encíclica
- Coloque o arquivo PDF em: `assets/docs/magnifica-humanitas.pdf`.
- Ajuste o nome no `index.html` se preferir outro arquivo/caminho.

## 4) Ativar Google Analytics 4
1. Abra `index.html`.
2. Localize o bloco comentado do Google Tag.
3. Substitua `G-XXXXXXXXXX` pelo ID real do GA4 e descomente o bloco.

## 5) Adesões
- Os cadastros são gravados em `data/subscribers.csv`.
- Campos: `created_at`, `name`, `email`, `interest`.

## 6) Métricas locais
- Acesse: `/admin/metrics.html`.
- O painel lê o resumo via `../metrics.php?summary=1`.
- O arquivo bruto fica protegido em `data/metrics.json`.

## 7) Observação institucional
**Magnifica Humanitas é uma iniciativa laical independente de estudo e pesquisa. Não constitui órgão oficial da Santa Sé nem a representa institucionalmente.**
