#!/bin/bash

# RESET
ufw --force reset

# BAASREEGLID
ufw default deny incoming
ufw default allow outgoing

# =====================================
# ÜLDISED HALDUSPORTID
# =====================================

# SSH
ufw allow 22/tcp

# =====================================
# VEEBISERVERID (Pilet 1 ja 4)
# =====================================

# HTTP
# ufw allow 80/tcp

# HTTPS
# ufw allow 443/tcp

# =====================================
# DNS SERVER
# =====================================

# DNS TCP
# ufw allow 53/tcp

# DNS UDP
# ufw allow 53/udp

# =====================================
# DHCP SERVER (Pilet 5)
# =====================================

# DHCP Server
# ufw allow 67/udp

# DHCP Client
# ufw allow 68/udp

# =====================================
# LOGISERVER (Pilet 2)
# =====================================

# Syslog UDP
# ufw allow 514/udp

# Syslog TCP
# ufw allow 514/tcp

# =====================================
# MONITOORING (Pilet 3)
# =====================================

# Zabbix Server
# ufw allow 10051/tcp

# Zabbix Agent
# ufw allow 10050/tcp

# Grafana
# ufw allow 3000/tcp

# Prometheus
# ufw allow 9090/tcp

# Node Exporter
# ufw allow 9100/tcp

# =====================================
# ANDMEBAASID
# =====================================

# MariaDB / MySQL
# ufw allow 3306/tcp

# PostgreSQL
# ufw allow 5432/tcp

# =====================================
# NFS (Pilet 6)
# =====================================

# NFS
# ufw allow 2049/tcp
# ufw allow 2049/udp

# RPCBind
# ufw allow 111/tcp
# ufw allow 111/udp

# =====================================
# iSCSI (Pilet 6)
# =====================================

# iSCSI Target
# ufw allow 3260/tcp

# =====================================
# SNMP (vajadusel monitooring)
# =====================================

# SNMP
# ufw allow 161/udp

# SNMP Trap
# ufw allow 162/udp

# =====================================
# ANSIBLE
# =====================================

# Ansible kasutab SSH-d
# ufw allow 22/tcp

# =====================================
# AKTIVEERI TULEMÜÜR
# =====================================

ufw --force enable

echo ""
echo "===== AKTIIVSED REEGLID ====="
ufw status numbered
