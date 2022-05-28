* composer config --global process-timeout 2000

* composer create-project drupal/recommended-project {name project}
* извлечь файлы с папки и потом только drush, а то прийдется sudo rm -r {name dir}!!!
composer require drush/drush

* ./vendor/bin/drush pm:enable {name} - установить модуль
* ./vendor/bin/drush pm:uninstall {name} - удалить модуль
* ./vendor/bin/drush cex -y - config
* ./vendor/bin/drush config:export - config
* ./vendor/bin/drush cr - rm cache
* ./vendor/bin/drush gen theme
* ./vendor/bin/drush ws - log

1. devel
2. paragraphs
3. webform (+ui)
4. content moderator
5. workflows
6. simple_sitemap
7. metatag
8. ds
9. inline form errors

core.extension - установленные модули и темы
