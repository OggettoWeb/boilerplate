class project
{
    include project::system
    include nginx
    include project::php
    include project::php_fpm
    include project::db
    include project::magento
    include project::rabbitmq
    include project::phpma
}