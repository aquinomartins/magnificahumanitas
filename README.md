# Magnifica Humanitas

Site editorial-infográfico da plataforma **Magnifica Humanitas**, iniciativa laical independente de estudo e pesquisa.

## Estrutura
- `index.html`: página inicial.
- `assets/style.css`: identidade visual e responsividade.
- `assets/script.js`: navegação mobile, adesão e métricas.
- `subscribe.php`: endpoint de cadastro de adesão.
- `metrics.php`: endpoint de métricas locais.
- `admin/metrics.html`: painel administrativo simples.
- `data/.htaccess`: bloqueio de acesso direto ao diretório de dados.

## SEO e identidade
O projeto usa metadados SEO + Open Graph com URL canônica `https://magnificahumanitas.com.br/` e imagem `assets/img/og-magnifica-humanitas.jpg`.

## Métricas
Eventos permitidos:
- `page_view_local`
- `read_vatican`
- `download_pdf`
- `adhesion_submit`
- `contact_click`
- `nav_click`

As métricas são agregadas em `data/metrics.json`, sem coleta de IP completo ou dados sensíveis.

## Adesão
Os cadastros são gravados em `data/subscribers.csv` com colunas:
- `created_at`
- `name`
- `email`
- `interest`

## Aviso institucional
Magnifica Humanitas é uma iniciativa laical independente de estudo e pesquisa. Não constitui órgão oficial da Santa Sé nem a representa institucionalmente.
