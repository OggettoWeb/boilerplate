#!/bin/bash
## Script for updating DB and media resources to latest version

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
puppet apply --hiera_config "$DIR/provision/hiera.yaml"  --verbose --modulepath /tmp/vagrant-puppet*/modules*/ /tmp/vagrant-puppet*/manifests/resources.pp
