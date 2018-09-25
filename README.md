# magento-lower-password-length

## Architecture
Modules that require theme changes <- Core theme -> Child "skin" themes

**Standalone modules** (This Repo) -> (no dependencies)

## Installation

```bash
# as root
systemctl stop cron
```
```bash
# as user
magento maintenance:enable
composer config repositories.magento-lower-password-length vcs https://github.com/bazedk/magento-lower-password-length
composer require bazedk/magento-lower-password-length:dev-master
magento module:enable Baze_LowerPasswordLength
magento setup:upgrade
magento setup:di:compile
magento setup:static-content:deploy {en_US,da_DK}
magento cache:clean
magento cache:flush
magento maintenance:disable
```
```bash
# as root
systemctl restart php7.1-fpm
systemctl start cron
```
