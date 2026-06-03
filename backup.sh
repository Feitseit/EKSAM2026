#!/bin/bash

# Kuupäev ja kellaaeg varukoopia failinime jaoks
DATE=$(date +"%Y-%m-%d_%H-%M-%S")

# Varukoopiate sihtkaust
BACKUP_DIR="/var/backups"

# Veebilehe failide asukoht
WEB_DIR="/var/www/kasutajatugi"

# Andmebaasi andmed
DB_HOST="10.0.20.10"
DB_NAME="kasutajatugi"
DB_USER="kasutajatugi"
DB_PASS="Kasutaja2026!"

# Loome veebilehe failidest pakitud varukoopia
tar -czf "$BACKUP_DIR/veeb_$DATE.tar.gz" "$WEB_DIR"

# Loome andmebaasist SQL varukoopia
mysqldump -h "$DB_HOST" -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" > "$BACKUP_DIR/andmebaas_$DATE.sql"

# Pakime andmebaasi varukoopia kokku
gzip "$BACKUP_DIR/andmebaas_$DATE.sql"

# Kustutame üle 7 päeva vanad varukoopiad
find "$BACKUP_DIR" -type f -mtime +7 -name "veeb_*.tar.gz" -delete
find "$BACKUP_DIR" -type f -mtime +7 -name "andmebaas_*.sql.gz" -delete
