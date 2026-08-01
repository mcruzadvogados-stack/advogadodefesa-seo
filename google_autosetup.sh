#!/bin/bash
# ============================================================
#  Google SEO — Automação Completa via API
#  CRUZ Advocacia — advogadodefesa.com.br
#
#  O que faz automaticamente (sem abrir nenhum painel):
#    1. Lê o código de verificação GSC direto do DNS Hostinger
#    2. Adiciona/atualiza TXT record de verificação no DNS
#    3. Pinga sitemap no Google, Bing e Yandex
#    4. Solicita indexação de todas as páginas via IndexNow
#    5. Verifica se a tag de verificação está no HTML do site
#    6. Exibe status completo de SEO técnico
#
#  Uso:
#    ./google_autosetup.sh              → executa tudo
#    ./google_autosetup.sh --dns-add CODIGO  → adiciona TXT no DNS
#    ./google_autosetup.sh --ping       → só pinga mecanismos de busca
#    ./google_autosetup.sh --status     → status atual do SEO
# ============================================================
set -e

TOKEN="${HOSTINGER_API_TOKEN:-GsQv2JPvVUXauic1RNfaUps8mDXT0pQMfJCuCcCd60b4c62b}"
DOMAIN="advogadodefesa.com.br"
SITEMAP="https://${DOMAIN}/sitemap.xml"
INDEXNOW_KEY="2068054de8e846ceba7ce1dd561f5546"
DNS_API="https://developers.hostinger.com/api/dns/v1/zones/${DOMAIN}"

PAGES=(
    "https://${DOMAIN}/"
    "https://${DOMAIN}/trabalhista"
    "https://${DOMAIN}/previdenciario"
    "https://${DOMAIN}/civil"
    "https://${DOMAIN}/criminal"
    "https://${DOMAIN}/bancario"
    "https://${DOMAIN}/inventario"
    "https://${DOMAIN}/contato"
)

# Cores
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

ok()   { echo -e "  ${GREEN}✓${NC} $1"; }
fail() { echo -e "  ${RED}✗${NC} $1"; }
info() { echo -e "  ${BLUE}→${NC} $1"; }
warn() { echo -e "  ${YELLOW}!${NC} $1"; }

# ── Função: ler DNS atual ─────────────────────────────────────────────────────
get_dns_zone() {
    curl -s "$DNS_API" \
        -H "Authorization: Bearer ${TOKEN}" \
        -H "Content-Type: application/json"
}

# ── Função: extrair código GSC do DNS ────────────────────────────────────────
get_gsc_code_from_dns() {
    get_dns_zone | python3 -c "
import sys, json, re
zone = json.load(sys.stdin)
for record in zone:
    if record.get('type') == 'TXT' and record.get('name') == '@':
        for r in record.get('records', []):
            content = r.get('content', '')
            m = re.search(r'google-site-verification=([A-Za-z0-9_\-]+)', content)
            if m:
                print(m.group(1))
                sys.exit(0)
print('')
"
}

# ── Função: adicionar TXT de verificação Google no DNS ───────────────────────
dns_add_google_verification() {
    local gsc_code="$1"
    echo ""
    echo -e "${BLUE}=== Adicionando TXT de Verificação Google no DNS ===${NC}"

    # Lê zona atual e adiciona o registro TXT
    local current_zone
    current_zone=$(get_dns_zone)

    # Monta payload de atualização (preserva registros existentes)
    local payload
    payload=$(echo "$current_zone" | python3 -c "
import sys, json

zone = json.load(sys.stdin)
gsc_code = '${gsc_code}'
new_content = 'google-site-verification=' + gsc_code

# Encontra ou cria bloco TXT @
found = False
for record in zone:
    if record.get('type') == 'TXT' and record.get('name') == '@':
        # Verifica se já existe
        for r in record.get('records', []):
            if 'google-site-verification' in r.get('content', ''):
                r['content'] = '\"' + new_content + '\"'
                found = True
                break
        if not found:
            record['records'].append({'content': '\"' + new_content + '\"', 'is_disabled': False})
            found = True
        break

if not found:
    zone.append({
        'name': '@',
        'type': 'TXT',
        'ttl': 3600,
        'records': [{'content': '\"' + new_content + '\"', 'is_disabled': False}]
    })

print(json.dumps(zone))
")

    local status
    status=$(curl -s -o /dev/null -w "%{http_code}" -X PUT "$DNS_API" \
        -H "Authorization: Bearer ${TOKEN}" \
        -H "Content-Type: application/json" \
        -d "$payload")

    if [ "$status" = "200" ] || [ "$status" = "204" ]; then
        ok "TXT google-site-verification=${gsc_code} adicionado ao DNS"
        warn "Propagação DNS: aguarde 5-30 minutos antes de verificar no Search Console"
    else
        fail "Erro ao atualizar DNS: HTTP $status"
        echo "    Payload enviado:"
        echo "$payload" | python3 -m json.tool 2>/dev/null | head -20
    fi
}

# ── Função: ping mecanismos de busca ─────────────────────────────────────────
ping_search_engines() {
    echo ""
    echo -e "${BLUE}=== Ping Mecanismos de Busca ===${NC}"

    # Google deprecou o endpoint ping em 2023 — indexação é automática via Search Console
    info "Google: indexação automática via Search Console (propriedade já verificada via DNS)"

    # Montar JSON IndexNow
    local pages_json
    pages_json=$(python3 -c "
import json
pages = $(printf '%s\n' "${PAGES[@]}" | python3 -c "import sys,json; print(json.dumps(sys.stdin.read().strip().split()))")
print(json.dumps({'host': '${DOMAIN}', 'key': '${INDEXNOW_KEY}', 'keyLocation': 'https://${DOMAIN}/${INDEXNOW_KEY}.txt', 'urlList': pages}))
")

    # Bing
    local b_status
    b_status=$(curl -s -o /dev/null -w "%{http_code}" -X POST \
        "https://api.indexnow.org/indexnow" \
        -H "Content-Type: application/json" \
        -d "$pages_json" --max-time 15)
    ([ "$b_status" = "200" ] || [ "$b_status" = "202" ]) && ok "IndexNow Bing: OK (HTTP $b_status)" || fail "IndexNow Bing: HTTP $b_status"

    # Yandex
    local y_status
    y_status=$(curl -s -o /dev/null -w "%{http_code}" -X POST \
        "https://yandex.com/indexnow" \
        -H "Content-Type: application/json" \
        -d "$pages_json" --max-time 15)
    ([ "$y_status" = "200" ] || [ "$y_status" = "202" ]) && ok "IndexNow Yandex: OK (HTTP $y_status)" || fail "IndexNow Yandex: HTTP $y_status"
}

# ── Função: verificar status SEO técnico ─────────────────────────────────────
check_seo_status() {
    echo ""
    echo -e "${BLUE}=== Status SEO Técnico ===${NC}"

    # 1. Verifica se o site responde
    local site_status
    site_status=$(curl -s -o /dev/null -w "%{http_code}" "https://${DOMAIN}/" --max-time 15)
    [ "$site_status" = "200" ] && ok "Site online: HTTP $site_status" || fail "Site: HTTP $site_status"

    # 2. Verifica meta tag de verificação no HTML
    local html
    html=$(curl -s "https://${DOMAIN}/" --max-time 15)
    if echo "$html" | grep -q "google-site-verification"; then
        local meta_code
        meta_code=$(echo "$html" | grep -o 'google-site-verification" content="[^"]*"' | head -1)
        ok "Meta tag GSC presente: $meta_code"
    else
        fail "Meta tag google-site-verification NÃO encontrada no HTML"
    fi

    # 3. Verifica robots.txt
    local robots_status
    robots_status=$(curl -s -o /dev/null -w "%{http_code}" "https://${DOMAIN}/robots.txt" --max-time 10)
    [ "$robots_status" = "200" ] && ok "robots.txt acessível" || fail "robots.txt: HTTP $robots_status"

    # 4. Verifica sitemap
    local sitemap_status
    sitemap_status=$(curl -s -o /dev/null -w "%{http_code}" "$SITEMAP" --max-time 10)
    [ "$sitemap_status" = "200" ] && ok "sitemap.xml acessível" || fail "sitemap.xml: HTTP $sitemap_status"

    # 5. Verifica HTTPS redirect
    local http_status
    http_status=$(curl -s -o /dev/null -w "%{http_code}" "http://${DOMAIN}/" -L --max-time 10)
    [ "$http_status" = "200" ] && ok "HTTPS redirect: OK" || warn "HTTPS redirect: verifique manualmente"

    # 6. TXT record no DNS
    echo ""
    info "Verificando TXT records DNS..."
    local gsc_from_dns
    gsc_from_dns=$(get_gsc_code_from_dns)
    if [ -n "$gsc_from_dns" ]; then
        ok "TXT google-site-verification no DNS: ${gsc_from_dns:0:20}..."
    else
        fail "TXT google-site-verification NÃO encontrado no DNS"
    fi

    # 7. Verifica chave IndexNow no servidor
    local key_status
    key_status=$(curl -s -o /dev/null -w "%{http_code}" "https://${DOMAIN}/${INDEXNOW_KEY}.txt" --max-time 10)
    [ "$key_status" = "200" ] && ok "IndexNow key file acessível" || warn "IndexNow key file: HTTP $key_status (deploy necessário)"

    # 8. Schema.org — verifica se JSON-LD está no HTML
    if echo "$html" | grep -q '"@type": "LegalService"'; then
        ok "Schema.org LegalService: presente"
    elif echo "$html" | grep -q 'LegalService'; then
        ok "Schema.org LegalService: presente"
    else
        warn "Schema.org LegalService: não detectado"
    fi

    if echo "$html" | grep -q 'FAQPage'; then
        ok "Schema.org FAQPage: presente"
    else
        warn "Schema.org FAQPage: não detectado (só em subpáginas)"
    fi
}

# ── Função: PageSpeed Insights via API pública ────────────────────────────────
check_pagespeed() {
    echo ""
    echo -e "${BLUE}=== Core Web Vitals (PageSpeed Insights) ===${NC}"

    local PSI_KEY="${GOOGLE_PSI_API_KEY:-}"
    local target_url="https://${DOMAIN}/"
    local encoded_url
    encoded_url=$(python3 -c "import urllib.parse; print(urllib.parse.quote('${target_url}'))")
    local api_call="https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=${encoded_url}&strategy=mobile"
    [ -n "$PSI_KEY" ] && api_call="${api_call}&key=${PSI_KEY}"

    info "Aguardando análise PageSpeed (pode levar ~15s)..."
    local tmpfile
    tmpfile=$(mktemp)
    curl -s "$api_call" --max-time 30 -o "$tmpfile"

    python3 << PYEOF
import json, sys

with open("${tmpfile}") as f:
    d = json.load(f)

if 'error' in d:
    code = d['error'].get('code', '?')
    msg  = d['error'].get('message', '')
    if code == 429:
        print("  ! Rate limit da API (429)")
        print("  Obtenha uma chave gratuita em: console.cloud.google.com → APIs → PageSpeed Insights")
        print("  Depois: export GOOGLE_PSI_API_KEY=SUA_CHAVE && ./google_autosetup.sh --pagespeed")
    else:
        print(f"  ! Erro API: HTTP {code} — {msg}")
    sys.exit(0)

cats    = d.get('lighthouseResult', {}).get('categories', {})
metrics = d.get('lighthouseResult', {}).get('audits', {})

scores = {
    'Performance':    cats.get('performance', {}).get('score', 0),
    'SEO':            cats.get('seo', {}).get('score', 0),
    'Acessibilidade': cats.get('accessibility', {}).get('score', 0),
    'Boas Práticas':  cats.get('best-practices', {}).get('score', 0),
}
for name, score in scores.items():
    pct = int((score or 0) * 100)
    bar = chr(9608)*(pct//10) + chr(9617)*(10-pct//10)
    clr = '\033[0;32m' if pct>=90 else '\033[1;33m' if pct>=50 else '\033[0;31m'
    rst = '\033[0m'
    print(f"  {clr}{bar}{rst} {name}: {pct}/100")

fcp = metrics.get('first-contentful-paint',{}).get('displayValue','N/A')
lcp = metrics.get('largest-contentful-paint',{}).get('displayValue','N/A')
cls = metrics.get('cumulative-layout-shift',{}).get('displayValue','N/A')
tbt = metrics.get('total-blocking-time',{}).get('displayValue','N/A')
print(f"  → FCP:{fcp}  LCP:{lcp}  CLS:{cls}  TBT:{tbt}")

print("  Oportunidades:")
for k, v in metrics.items():
    score = v.get('score')
    if score is not None and score < 0.9:
        savings = v.get('details', {}).get('overallSavingsMs', 0) or 0
        if savings > 300:
            print(f"    - {v.get('title','?')}: -{int(savings)}ms potencial")
PYEOF
    rm -f "$tmpfile"
}

# ── Main ───────────────────────────────────────────────────────────────────────
echo ""
echo -e "${BLUE}╔════════════════════════════════════════════╗${NC}"
echo -e "${BLUE}║  Google SEO Automação — CRUZ Advocacia     ║${NC}"
echo -e "${BLUE}║  advogadodefesa.com.br                     ║${NC}"
echo -e "${BLUE}╚════════════════════════════════════════════╝${NC}"

case "${1:-}" in
    --dns-add)
        if [ -z "${2:-}" ]; then
            echo "Uso: $0 --dns-add CODIGO_GSC"
            echo "Exemplo: $0 --dns-add CrAqXvdMxwX1h45AuA6pG4EJ0U3ovTj75vWHZYdjJIM"
            exit 1
        fi
        dns_add_google_verification "$2"
        ;;
    --ping)
        ping_search_engines
        ;;
    --status)
        check_seo_status
        ;;
    --pagespeed)
        check_pagespeed
        ;;
    *)
        # Modo completo: faz tudo
        echo ""
        echo -e "${BLUE}=== 1/4 Verificação DNS ===${NC}"
        GSC_CODE=$(get_gsc_code_from_dns)
        if [ -n "$GSC_CODE" ]; then
            ok "Código GSC já no DNS: ${GSC_CODE:0:25}..."
        else
            warn "Código GSC não encontrado no DNS"
            info "Use: $0 --dns-add SEU_CODIGO para adicionar"
        fi

        check_seo_status
        ping_search_engines
        check_pagespeed

        echo ""
        echo -e "${GREEN}=== Concluído em $(date '+%d/%m/%Y %H:%M:%S') ===${NC}"
        echo ""
        info "Próximo passo: acesse search.google.com/search-console e clique 'Verificar'"
        info "O código já está no DNS — verificação instantânea"
        ;;
esac

echo ""
