class puphpet {

  include ::puphpet::params

  Exec { path => [ '/bin/', '/sbin/', '/usr/bin/', '/usr/sbin/' ] }
  Vcsrepo { require => Package['git'] }

  class { '::puphpet::cron': }
  class { '::puphpet::firewall': }
  class { '::puphpet::locale': }
  class { '::puphpet::ruby': }
  class { '::puphpet::server': }
  class { '::puphpet::usersgroups': }

  if array_true($puphpet::params::hiera['apache'], 'install') {
    class { '::puphpet::apache::install': }
  }

  if array_true($puphpet::params::hiera['beanstalkd'], 'install') {
    class { '::puphpet::beanstalkd::install': }
  }

  if array_true($puphpet::params::hiera['drush'], 'install') {
    class { '::puphpet::drush::install': }
  }

  if array_true($puphpet::params::hiera['elasticsearch'], 'install') {
    class { '::puphpet::elasticsearch::install': }
  }

  if array_true($puphpet::params::hiera['hhvm'], 'install') {
    class { '::puphpet::hhvm::install': }
  }

  if array_true($puphpet::params::hiera['mailhog'], 'install') {
    class { '::puphpet::mailhog::install': }
  }

  if array_true($puphpet::params::hiera['mariadb'], 'install')
    and ! array_true($puphpet::params::hiera['mysql'], 'install')
  {
    class { '::puphpet::mariadb::install': }
  }

  if array_true($puphpet::params::hiera['mongodb'], 'install') {
    class { '::puphpet::mongodb::install': }
  }

  if array_true($puphpet::params::hiera['mysql'], 'install')
    and ! array_true($puphpet::params::hiera['mariadb'], 'install')
  {
    class { '::puphpet::mysql::install': }
  }

  if array_true($puphpet::params::hiera['nginx'], 'install') {
    class { '::puphpet::nginx::install': }
  }

  if array_true($puphpet::params::hiera['nodejs'], 'install') {
    class { '::puphpet::nodejs::install': }
  }

  if array_true($puphpet::params::hiera['php'], 'install') {
    class { '::puphpet::php::install': }

    if array_true($puphpet::params::hiera['blackfire'], 'install') {
      class { '::puphpet::blackfire::install': }
    }

    if array_true($puphpet::params::hiera['xhprof'], 'install') {
      class { '::puphpet::xhprof': }
    }
  }

  if array_true($puphpet::params::hiera['postgresql'], 'install') {
    class { '::puphpet::postgresql::install': }
  }

  if array_true($puphpet::params::hiera['python'], 'install') {
    class { '::puphpet::python::install': }
  }

  if array_true($puphpet::params::hiera['rabbitmq'], 'install') {
    class { '::puphpet::rabbitmq::install': }
  }

  if array_true($puphpet::params::hiera['redis'], 'install') {
    class { '::puphpet::redis::install': }
  }

  if array_true($puphpet::params::hiera['letsencrypt'], 'install') {
    class { '::puphpet::letsencrypt::install': }
  }

  if array_true($puphpet::params::hiera['solr'], 'install') {
    class { '::puphpet::solr::install': }
  }

  if array_true($puphpet::params::hiera['sqlite'], 'install') {
    class { '::puphpet::sqlite::install': }
  }

  if array_true($puphpet::params::hiera['wpcli'], 'install') {
    class { '::puphpet::wpcli': }
  }

}
