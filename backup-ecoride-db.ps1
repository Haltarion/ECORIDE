# backup-ecoride-db.ps1
# Sauvegarde MariaDB (conteneur Docker Compose) vers OneDrive avec rotation

# --- Paramètres à adapter ---
$projectPath = "C:\Users\micha\repos\EcoRide"  # dossier où se trouve docker-compose.yml
$composeFile  = Join-Path $projectPath "docker-compose.yml"
$projectName  = "ecoride"
$composeFile = Join-Path $projectPath "docker-compose.yml"
$backupDir   = "C:\Users\micha\OneDrive\Documents\01-Programmation\CloudBackups\ecoride-db"
$dbService   = "db"
$dbName      = "app"
$dbUser      = "app"
$dbPass      = "app"
$retentionDays = 14   # nombre de jours à conserver
# ----------------------------

# forcer l’UTF-8 côté PowerShell
[Console]::OutputEncoding = [System.Text.Encoding]::UTF8

# Stop au premier échec
$ErrorActionPreference = "Stop"

# Crée le dossier de backup si besoin
if (-not (Test-Path -LiteralPath $backupDir)) {
    New-Item -ItemType Directory -Path $backupDir | Out-Null
}

# Nom de fichier horodaté
$timestamp = Get-Date -Format "yyyy-MM-dd_HHmmss"
$backupFile = Join-Path $backupDir "ecoride-db_$timestamp.sql"
$logFile    = Join-Path $backupDir "backup.log"

function Write-Log($message) {
    $line = "{0} {1}" -f (Get-Date -Format "yyyy-MM-dd HH:mm:ss"), $message
    $line | Tee-Object -FilePath $logFile -Append
}

try {
    Write-Log "Début backup -> $backupFile"

    # On se place dans le projet (pour que docker compose trouve le bon fichier)
    Set-Location -Path $projectPath

    # Dump SQL (utilise app)
    # -T : indispensable en non-interactif
    $dump = docker compose -p $projectName -f $composeFile exec -T $dbService mysqldump -u $dbUser -p$dbPass $dbName

    if (-not $dump) {
        throw "Dump vide (la commande mysqldump n'a rien retourne)."
    }

    if ($dump -notmatch "CREATE TABLE|INSERT INTO") {
        throw "Dump inattendu (aucune instruction CREATE/INSERT detectee)."
    }

    # Écrit le dump en UTF-8
    $dump | Out-File -FilePath $backupFile -Encoding utf8

    # Vérification taille
    $size = (Get-Item -LiteralPath $backupFile).Length
    Write-Log "Backup OK (taille: $size octets)"

    # Rotation : supprime les backups plus vieux que $retentionDays
    $limit = (Get-Date).AddDays(-$retentionDays)
    Get-ChildItem -LiteralPath $backupDir -Filter "ecoride-db_*.sql" |
        Where-Object { $_.LastWriteTime -lt $limit } |
        ForEach-Object {
            Write-Log "Suppression ancien backup: $($_.FullName)"
            Remove-Item -LiteralPath $_.FullName -Force
        }

    Write-Log "Fin backup: OK"
    exit 0
}
catch {
    Write-Log "ERREUR: $($_.Exception.Message)"
    exit 1
}
