#!/bin/bash
# Deploy automático advogadodefesa.com.br via Hostinger API
# Uso: ./deploy.sh [arquivo1] [arquivo2] ...
#      ./deploy.sh           → deploy de todos os arquivos locais
# Token configurado em ~/.claude/settings.json → HOSTINGER_API_TOKEN
set -e

TOKEN="${HOSTINGER_API_TOKEN:-GsQv2JPvVUXauic1RNfaUps8mDXT0pQMfJCuCcCd60b4c62b}"
DOMAIN="advogadodefesa.com.br"
USERNAME="u530538090"
DIR="$(cd "$(dirname "$0")" && pwd)"

ALLOWED=(
    "index.php"
    "src/pages/index.php"
    "src/css/style.css"
    "src/css/430.css"
    "src/css/640.css"
    "src/css/768.css"
    "src/css/1024.css"
    "src/css/1280.css"
    "src/css/1536.css"
    "src/css/1630.css"
)

# Obtém credenciais TUS da API Hostinger
get_creds() {
    curl -s -X POST \
        "https://developers.hostinger.com/api/hosting/v1/files/upload-urls" \
        -H "Authorization: Bearer ${TOKEN}" \
        -H "Content-Type: application/json" \
        -d "{\"username\":\"${USERNAME}\",\"domain\":\"${DOMAIN}\"}"
}

# Faz upload de um arquivo via TUS
deploy_file() {
    local file="$1"
    local local_path="${DIR}/${file}"

    if [ ! -f "$local_path" ]; then
        echo "  → $file ... IGNORADO (não existe localmente)"
        return
    fi

    local file_size
    file_size=$(wc -c < "$local_path" | tr -d ' ')
    echo -n "  → $file (${file_size}B) ... "

    local slot_status
    slot_status=$(curl -s -o /dev/null -w "%{http_code}" -X POST \
        "${UPLOAD_URL}/${file}?override=true" \
        -H "X-Auth: ${AUTH_KEY}" \
        -H "X-Auth-Rest: ${REST_KEY}" \
        -H "upload-length: ${file_size}" \
        -H "upload-offset: 0" \
        -d "")

    if [ "$slot_status" != "201" ]; then
        echo "ERRO slot HTTP $slot_status"
        exit 1
    fi

    local upload_status
    upload_status=$(curl -s -o /dev/null -w "%{http_code}" -X PATCH \
        "${UPLOAD_URL}/${file}?override=true" \
        -H "X-Auth: ${AUTH_KEY}" \
        -H "X-Auth-Rest: ${REST_KEY}" \
        -H "upload-offset: 0" \
        -H "Content-Type: application/offset+octet-stream" \
        --data-binary "@${local_path}")

    if [ "$upload_status" = "204" ] || [ "$upload_status" = "200" ]; then
        echo "OK"
    else
        echo "ERRO upload HTTP $upload_status"
        exit 1
    fi
}

echo "=== Deploy advogadodefesa.com.br ==="
echo -n "  Obtendo credenciais ... "

CREDS=$(get_creds)
UPLOAD_URL=$(echo "$CREDS" | python3 -c "import sys,json; d=json.load(sys.stdin); print(d['url'])")
AUTH_KEY=$(echo "$CREDS" | python3 -c "import sys,json; d=json.load(sys.stdin); print(d['auth_key'])")
REST_KEY=$(echo "$CREDS" | python3 -c "import sys,json; d=json.load(sys.stdin); print(d['rest_auth_key'])")

[ -z "$UPLOAD_URL" ] && { echo "ERRO"; echo "$CREDS"; exit 1; }
echo "OK"

# Arquivos a deployar: argumentos ou todos os permitidos
if [ $# -gt 0 ]; then
    FILES=("$@")
else
    FILES=("${ALLOWED[@]}")
fi

for file in "${FILES[@]}"; do
    deploy_file "$file"
done

echo "=== Concluído ==="
