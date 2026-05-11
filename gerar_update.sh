#!/usr/bin/env bash
set -euo pipefail

BASE_REF="HEAD~1"
TARGET_REF="WORKTREE"
OUTPUT_DIR="Update Rotina"
CLEAN_OUTPUT="no"
INCLUDE_UNTRACKED="no"
DRY_RUN="no"

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
  --dry-run           Mostra o que seria copiado, sem alterar arquivos
  -h, --help          Mostra esta ajuda

Exemplos:
  ./gerar_update.sh --base v1.20.0 --target WORKTREE --clean
  ./gerar_update.sh --base v1.20.0 --target HEAD --out update-pack
  ./gerar_update.sh --base HEAD~3 --out "Update Rotina"
  ./gerar_update.sh --base HEAD~1 --untracked --dry-run

Observacoes:
  - Arquivos deletados nao sao copiados para o pacote.
  - A propria pasta de destino, .git e pasta_sem_referencia sao ignoradas.
USAGE
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

TMP_LIST="$(mktemp)"
trap 'rm -f "$TMP_LIST"' EXIT

if [ "$TARGET_REF" = "WORKTREE" ]; then
  git diff --name-only --diff-filter=ACMRT "$BASE_REF" > "$TMP_LIST"
else
  git diff --name-only --diff-filter=ACMRT "$BASE_REF" "$TARGET_REF" > "$TMP_LIST"
fi

if [ "$INCLUDE_UNTRACKED" = "yes" ]; then
  git ls-files --others --exclude-standard >> "$TMP_LIST"
fi

sort -u "$TMP_LIST" -o "$TMP_LIST"

FILTERED_LIST="$(mktemp)"
trap 'rm -f "$TMP_LIST" "$FILTERED_LIST"' EXIT

while IFS= read -r file; do
  case "$file" in
    ""|.git/*|"$OUTPUT_DIR"/*|pasta_sem_referencia/*)
      continue
      ;;
  esac

  if [ -f "$file" ]; then
    printf '%s\n' "$file" >> "$FILTERED_LIST"
  fi
done < "$TMP_LIST"

if [ ! -s "$FILTERED_LIST" ]; then
  echo "Nenhum arquivo modificado para copiar."
  exit 0
fi

echo "Arquivos que entrarao no pacote:"
sed 's/^/  - /' "$FILTERED_LIST"

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

echo
echo "Pacote gerado em: $OUTPUT_DIR"
