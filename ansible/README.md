# Playbook Ansible — Assiduo (installation sans Docker)

## Prérequis sur ta machine de contrôle (ton pc)

```bash
sudo apt update 
sudo apt install -y ansible git
ansible-galaxy collection install community.mysql community.general --force
```

## Avant de lancer

1. **Éditer `inventory.ini`** : remplacer le login par celui de ton compte SSH réel, vérifier aussi que l'adresse corresponde à celle de la machine.
2. **Changer le login** dans `playbook.yml` remplacer le login par le votre dans les variables (ligne 24)
   ```bash
   ansible_user : "selhani" 
   ```
3. **Les comptes utilisateurs et l'accès SSH doivent déjà exister** sur la VM (voir la doc *Création des comptes développeurs* qu'on a faite avant) — ce playbook part du principe que tu peux déjà te connecter en SSH avec sudo.

## Lancer le playbook

```bash
ansible-playbook -i inventory.ini playbook.yml --ask-become-pass --ask-vault-pass
```

`--ask-become-pass` te demande ton mot de passe sudo (celui de ton compte, pas de root — cohérent avec ce qu'on a mis en place).

`--ask-vault-pass` te demande le mot de passe Vault qui permet de chiffrer les données sensibles.

## Ce que fait le playbook, dans l'ordre

1. Paquets de base (git, curl, etc.)
2. Dépôt Sury + installation de PHP 8.4 et ses extensions + Composer
3. Dépôt officiel MySQL + installation de MySQL 8.4 LTS, création de la base et d'un utilisateur applicatif à droits restreints (pas root)
4. Téléchargement du binaire FrankenPHP + service systemd + Caddyfile
5. Clone du dépôt Git, `composer install`, migrations Doctrine, démarrage du service

## Après exécution

Vérifie que tout tourne :
```bash
ssh login@10.20.2.2 "systemctl status frankenphp mysql"
curl -kI https://10.20.2.2
```

## Points à retravailler avant la recette officielle

- **Sauvegarde automatisée** (`mysqldump`, cron) : pas encore dans ce playbook, à ajouter en tâche supplémentaire (§9 de l'annexe).
- **Supervision (Uptime Kuma), fail2ban, nftables** : hors périmètre de ce playbook, à traiter séparément.
