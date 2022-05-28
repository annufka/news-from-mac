composer config --global process-timeout 2000

composer create-project drupal/recommended-project {name project}
извлечь файлы с папки и потом только drush, а то прийдется sudo rm -r {name dir}!!!
composer require drush/drush

./vendor/bin/drush pm:enable {name} - установить модуль
./vendor/bin/drush pm:uninstall {name} - удалить модуль
./vendor/bin/drush cex -y - config
./vendor/bin/drush config:export - config
./vendor/bin/drush cr - rm cache
./vendor/bin/drush gen theme


devel
paragraphs
webform (+ui)
content moderator
workflows
simple_sitemap
metatag
ds
inline form errors



core.extension - установленные модули и темы
