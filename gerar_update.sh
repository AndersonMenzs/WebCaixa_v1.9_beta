#!/usr/bin/env bash
set -euo pipefail

BASE_REF="HEAD~1"
TARGET_REF="WORKTREE"
OUTPUT_DIR="Update Rotina"
CLEAN_OUTPUT="no"
INCLUDE_UNTRACKED="no"
DRY_RUN="no"
VERSION_BUMP="patch"
SET_VERSION=""
VERSION_PREFIX="WebCaixa v"
VERSION_INCLUDE_ARGS=(
  --include='*.php'
  --include='*.html'
  --include='*.htm'
  --include='*.md'
  --include='*.js'
  --include='*.css'
  --include='*.sql'
  --include='*.txt'
  --include='*.json'
  --include='*.xml'
  --include='*.svg'
)

usage() {
  cat <<'USAGE'
Uso:
  ./gerar_update.sh [opcoes]

Gera uma pasta de atualizacao contendo somente arquivos modificados no Git,
preservando a estrutura original de diretorios.

Opcoes:
  --base REF          Referencia inicial para comparar. Padrao: HEAD~1
  --target REF        Referencia final para comparar. Padrao: WORKTREE
  --out DIR           Pasta de destino. Padrao: "Update Rotina"
  --clean             Limpa a pasta de destino antes de gerar o pacote
  --untracked         Inclui arquivos novos ainda nao rastreados pelo Git
  --bump TIPO         Escalona a versao: patch, minor, major ou none. Padrao: patch
  --version VERSAO    Define uma versao exata, exemplo: 1.21.0_beta
  --dry-run           Mostra o que seria copiado, sem alterar arquivos
  -h, --help          Mostra esta ajuda

Exemplos:
  ./gerar_update.sh --base v1.20.0 --target WORKTREE --clean
  ./gerar_update.sh --base v1.20.0 --target HEAD --out update-pack
  ./gerar_update.sh --base HEAD~3 --out "Update Rotina"
  ./gerar_update.sh --base HEAD~1 --untracked --dry-run
  ./gerar_update.sh --bump minor --clean
  ./gerar_update.sh --version 1.21.0_beta --clean

Observacoes:
  - Arquivos deletados nao sao copiados para o pacote.
  - A propria pasta de destino, .git, pasta_sem_referencia e _em_referencia sao ignoradas.
  - O pacote inclui qualquer arquivo modificado rastreado pelo Git, nao apenas PHP.
  - Arquivos novos nao rastreados entram somente com --untracked.
  - Por padrao, a versao WebCaixa e escalonada em patch antes de gerar.
USAGE
}

current_version() {
  grep -Rho \
    --exclude-dir=.git \
    --exclude-dir="$OUTPUT_DIR" \
    --exclude-dir=pasta_sem_referencia \
    --exclude-dir=_em_referencia \
    "${VERSION_INCLUDE_ARGS[@]}" \
    "${VERSION_PREFIX}[0-9][0-9.]*\\(_[A-Za-z0-9.-]*\\)\\?" . |
    sed "s/^${VERSION_PREFIX}//" |
    awk '
      {
        original = $0
        core = original
        sub(/_.*/, "", core)
        parts = split(core, nums, ".")
        major = nums[1] + 0
        minor = nums[2] + 0
        patch = nums[3] + 0
        printf "%010d %010d %010d %010d %s\n", major, minor, patch, parts, original
      }
    ' |
    sort |
    tail -n 1 |
    awk '{print $5}'
}

bump_version() {
  version="$1"
  bump_type="$2"
  core="${version%%_*}"
  suffix=""

  if [ "$version" != "$core" ]; then
    suffix="_${version#*_}"
  fi

  IFS=. read -r major minor patch <<EOF_VERSION
$core
EOF_VERSION

  major="${major:-0}"
  minor="${minor:-0}"
  patch="${patch:-0}"

  case "$bump_type" in
    major)
      major=$((major + 1))
      minor=0
      patch=0
      ;;
    minor)
      minor=$((minor + 1))
      patch=0
      ;;
    patch)
      patch=$((patch + 1))
      ;;
    none)
      ;;
    *)
      echo "Erro: --bump aceita apenas major, minor, patch ou none." >&2
      exit 1
      ;;
  esac

  printf '%s.%s.%s%s\n' "$major" "$minor" "$patch" "$suffix"
}

update_project_version() {
  old_version="$1"
  new_version="$2"

  if [ "$old_version" = "$new_version" ]; then
    return
  fi

  grep -RIlZ \
    --exclude-dir=.git \
    --exclude-dir="$OUTPUT_DIR" \
    --exclude-dir=pasta_sem_referencia \
    --exclude-dir=_em_referencia \
    "${VERSION_INCLUDE_ARGS[@]}" \
    "${VERSION_PREFIX}[0-9]" . |
    xargs -0 perl -pi -e "s/\\Q${VERSION_PREFIX}\\E[0-9]+(?:\\.[0-9]+){1,2}(?:_[A-Za-z0-9.-]+)?/${VERSION_PREFIX}${new_version}/g"
}

while [ "$#" -gt 0 ]; do
  case "$1" in
    --base)
      BASE_REF="${2:-}"
      shift 2
      ;;
    --target)
      TARGET_REF="${2:-}"
      shift 2
      ;;
    --out)
      OUTPUT_DIR="${2:-}"
      shift 2
      ;;
    --clean)
      CLEAN_OUTPUT="yes"
      shift
      ;;
    --untracked)
      INCLUDE_UNTRACKED="yes"
      shift
      ;;
    --bump)
      VERSION_BUMP="${2:-}"
      shift 2
      ;;
    --version)
      SET_VERSION="${2:-}"
      shift 2
      ;;
    --dry-run)
      DRY_RUN="yes"
      shift
      ;;
    -h|--help)
      usage
      exit 0
      ;;
    *)
      echo "Opcao desconhecida: $1" >&2
      usage >&2
      exit 1
      ;;
  esac
done

if [ -z "$BASE_REF" ] || [ -z "$TARGET_REF" ] || [ -z "$OUTPUT_DIR" ]; then
  echo "Erro: --base, --target e --out nao podem ficar vazios." >&2
  exit 1
fi

if ! git rev-parse --is-inside-work-tree >/dev/null 2>&1; then
  echo "Erro: este script precisa ser executado dentro de um repositorio Git." >&2
  exit 1
fi

git rev-parse --verify "$BASE_REF" >/dev/null
if [ "$TARGET_REF" != "WORKTREE" ]; then
  git rev-parse --verify "$TARGET_REF" >/dev/null
fi

REPO_ROOT="$(git rev-parse --show-toplevel)"
cd "$REPO_ROOT"

VERSION_BEFORE="$(current_version)"
VERSION_AFTER="$VERSION_BEFORE"

if [ -z "$VERSION_BEFORE" ]; then
  echo "Aviso: nenhuma versao WebCaixa encontrada para escalonar." >&2
else
  if [ -n "$SET_VERSION" ]; then
    VERSION_AFTER="$SET_VERSION"
  else
    VERSION_AFTER="$(bump_version "$VERSION_BEFORE" "$VERSION_BUMP")"
  fi

  if [ "$DRY_RUN" = "yes" ]; then
    if [ "$VERSION_BEFORE" != "$VERSION_AFTER" ]; then
      echo "Versao atual: ${VERSION_PREFIX}${VERSION_BEFORE}"
      echo "Proxima versao: ${VERSION_PREFIX}${VERSION_AFTER}"
      echo
    fi
  else
    update_project_version "$VERSION_BEFORE" "$VERSION_AFTER"
  fi
fi

TMP_LIST="$(mktemp)"
TMP_REMOVE_LIST="$(mktemp)"
trap 'rm -f "$TMP_LIST" "$TMP_REMOVE_LIST"' EXIT

if [ "$TARGET_REF" = "WORKTREE" ]; then
  git diff --name-only --diff-filter=ACMRT "$BASE_REF" > "$TMP_LIST"
  while IFS= read -r -d '' status; do
    case "$status" in
      D)
        IFS= read -r -d '' old_file
        printf '%s\n' "$old_file" >> "$TMP_REMOVE_LIST"
        ;;
      R*)
        IFS= read -r -d '' old_file
        IFS= read -r -d '' new_file
        printf '%s\n' "$old_file" >> "$TMP_REMOVE_LIST"
        ;;
    esac
  done < <(git diff --name-status -z --diff-filter=DR "$BASE_REF")
else
  git diff --name-only --diff-filter=ACMRT "$BASE_REF" "$TARGET_REF" > "$TMP_LIST"
  while IFS= read -r -d '' status; do
    case "$status" in
      D)
        IFS= read -r -d '' old_file
        printf '%s\n' "$old_file" >> "$TMP_REMOVE_LIST"
        ;;
      R*)
        IFS= read -r -d '' old_file
        IFS= read -r -d '' new_file
        printf '%s\n' "$old_file" >> "$TMP_REMOVE_LIST"
        ;;
    esac
  done < <(git diff --name-status -z --diff-filter=DR "$BASE_REF" "$TARGET_REF")
fi

if [ "$INCLUDE_UNTRACKED" = "yes" ]; then
  git ls-files --others --exclude-standard >> "$TMP_LIST"
fi

sort -u "$TMP_LIST" -o "$TMP_LIST"

FILTERED_LIST="$(mktemp)"
FILTERED_REMOVE_LIST="$(mktemp)"
trap 'rm -f "$TMP_LIST" "$TMP_REMOVE_LIST" "$FILTERED_LIST" "$FILTERED_REMOVE_LIST"' EXIT

while IFS= read -r file; do
  case "$file" in
    ""|.git/*|"$OUTPUT_DIR"/*|pasta_sem_referencia/*|_em_referencia/*)
      continue
      ;;
  esac

  if [ -f "$file" ]; then
    printf '%s\n' "$file" >> "$FILTERED_LIST"
  fi
done < "$TMP_LIST"

while IFS= read -r file; do
  case "$file" in
    ""|.git/*|"$OUTPUT_DIR"/*|pasta_sem_referencia/*|_em_referencia/*)
      continue
      ;;
  esac

  printf '%s\n' "$file" >> "$FILTERED_REMOVE_LIST"
done < "$TMP_REMOVE_LIST"

if [ ! -s "$FILTERED_LIST" ] && [ ! -s "$FILTERED_REMOVE_LIST" ]; then
  echo "Nenhum arquivo modificado para copiar."
  exit 0
fi

if [ -s "$FILTERED_LIST" ]; then
  echo "Arquivos que entrarao no pacote:"
  sed 's/^/  - /' "$FILTERED_LIST"
fi

if [ -s "$FILTERED_REMOVE_LIST" ]; then
  echo
  echo "Arquivos que devem ser removidos no destino:"
  sed 's/^/  - /' "$FILTERED_REMOVE_LIST"
fi

if [ "$DRY_RUN" = "yes" ]; then
  echo
  echo "Dry-run ativo: nada foi copiado."
  exit 0
fi

if [ -e "$OUTPUT_DIR" ] && [ "$CLEAN_OUTPUT" != "yes" ]; then
  echo
  echo "Erro: a pasta \"$OUTPUT_DIR\" ja existe." >&2
  echo "Use --clean para limpa-la antes de gerar o pacote, ou --out para escolher outra pasta." >&2
  exit 1
fi

if [ "$CLEAN_OUTPUT" = "yes" ] && [ -e "$OUTPUT_DIR" ]; then
  rm -rf -- "$OUTPUT_DIR"
fi

mkdir -p "$OUTPUT_DIR"

while IFS= read -r file; do
  mkdir -p "$OUTPUT_DIR/$(dirname "$file")"
  cp -p -- "$file" "$OUTPUT_DIR/$file"
done < "$FILTERED_LIST"

if [ -s "$FILTERED_REMOVE_LIST" ]; then
  cp -- "$FILTERED_REMOVE_LIST" "$OUTPUT_DIR/ARQUIVOS_REMOVER.txt"
fi

{
  echo "Projeto: WebCaixa"
  if [ -n "$VERSION_BEFORE" ]; then
    echo "Versao anterior: ${VERSION_PREFIX}${VERSION_BEFORE}"
    echo "Versao do pacote: ${VERSION_PREFIX}${VERSION_AFTER}"
  fi
  echo "Base: $BASE_REF"
  echo "Destino: $TARGET_REF"
  echo "Commit atual: $(git rev-parse --short HEAD)"
  echo "Gerado em: $(date '+%Y-%m-%d %H:%M:%S')"
} > "$OUTPUT_DIR/UPDATE_INFO.txt"

echo
echo "Pacote gerado em: $OUTPUT_DIR"
if [ -n "$VERSION_BEFORE" ]; then
  echo "Versao do pacote: ${VERSION_PREFIX}${VERSION_AFTER}"
fi
