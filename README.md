# Magnifica Humanitas

## 1) Como subir o site
1. Envie os arquivos para o servidor (ex.: `public_html`).
2. Mantenha a estrutura principal:
   - `index.html`
   - `enciclica.html`
   - `capitulos.html`
   - `capitulo-1.html` até `capitulo-5.html`
   - `cadernos.html`
   - `participar.html`
   - `assets/`
   - `subscribe.php`
   - `metrics.php`
   - `admin/metrics.html`
   - `data/`

## 2) Onde colocar as imagens editadas
- Placeholders atuais (texto/editáveis) em: `assets/img/desenhos/`.
- Quando quiser usar JPG final dos infográficos, adicione em: `assets/img/infograficos/`.

## 3) Arquivos preparados para substituição
Atualmente o HTML usa:
- `assets/img/desenhos/capitulo-1-desenho-1.svg`
- `assets/img/desenhos/capitulo-2-desenho-1.svg`
- `assets/img/desenhos/capitulo-3-desenho-1.svg`
- `assets/img/desenhos/capitulo-4-desenho-1.svg`
- `assets/img/desenhos/capitulo-5-desenho-1.svg`

Se preferir JPG, mantenha os nomes de referência por capítulo e atualize apenas o `src` das páginas.

## 4) Como ativar Google Analytics
1. Abra o `<head>` das páginas HTML.
2. Localize o bloco comentado do Google Tag.
3. Substitua `G-XXXXXXXXXX` pelo ID real.
4. Descomente o bloco.

## 5) Como verificar adesões
- As adesões ficam em `data/subscribers.csv`.

## 6) Como acessar métricas
- Painel: `/admin/metrics.html`
- Endpoint resumido: `/metrics.php?summary=1`

## 7) Como criar novas páginas de capítulo
1. Copie um arquivo `capitulo-X.html` existente.
2. Ajuste título, descrição, breadcrumb e `data-page-event`.
3. Crie o placeholder correspondente em `assets/img/desenhos/` ou `assets/img/infograficos/`.
4. Adicione link em `capitulos.html`.
