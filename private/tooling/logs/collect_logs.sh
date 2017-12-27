#!/bin/bash

# Site UUID from Dashboard URL, eg 12345678-1234-1234-abcd-0123456789ab
SITE_UUID=4061a3e5-7b6a-469b-a2a8-c3a25458635a
for app_server in $(dig +short appserver.live.$SITE_UUID.drush.in);
do
  mkdir -p "live"
  mkdir -p "live/app"
  mkdir -p "live/app/$app_server"
  sftp -o Port=2222 "live.$SITE_UUID@$app_server" << !
    cd logs
    lcd "live/app/$app_server"
    mget *.log
!
done

for app_server in $(dig +short appserver.test.$SITE_UUID.drush.in);
do
  mkdir -p "test"
  mkdir -p "test/app"
  mkdir -p "test/app/$app_server"
  sftp -o Port=2222 "test.$SITE_UUID@$app_server" << !
    cd logs
    lcd "test/app/$app_server"
    mget *.log
!
done
for app_server in $(dig +short appserver.dev.$SITE_UUID.drush.in);
do
  mkdir -p "dev"
  mkdir -p "dev/app"
  mkdir -p "dev/app/$app_server"
  sftp -o Port=2222 "dev.$SITE_UUID@$app_server" << !
    cd logs
    lcd "dev/app/$app_server"
    mget *.log
!
done

for db_server in $(dig dbserver.live.$SITE_UUID.drush.in +short)
do
  mkdir -p "live"
  mkdir -p "live/db"
  mkdir -p "live/db/$db_server"
  sftp -o Port=2222 "live.$SITE_UUID@dbserver.live.$SITE_UUID.drush.in" << !
    cd logs
    lcd "live/db/$db_server"
    mget *.log
!
done

for db_server in $(dig dbserver.test.$SITE_UUID.drush.in +short)
do
  mkdir -p "test"
  mkdir -p "test/db"
  mkdir -p "test/db/$db_server"
  sftp -o Port=2222 "test.$SITE_UUID@dbserver.test.$SITE_UUID.drush.in" << !
    cd logs
    lcd "test/db/$db_server"
    mget *.log
!
done

for db_server in $(dig dbserver.dev.$SITE_UUID.drush.in +short)
do
  mkdir -p "dev"
  mkdir -p "dev/db"
  mkdir -p "dev/db/$db_server"
  sftp -o Port=2222 "dev.$SITE_UUID@dbserver.dev.$SITE_UUID.drush.in" << !
    cd logs
    lcd "dev/db/$db_server"
    mget *.log
!
done
