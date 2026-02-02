# Mediawiki
Helm chart for mediawiki to deploy on kubernetes

# Pre-requisites 

1.) A Kubernetes cluster on cloud or Raspberry pi. You can also run a minikube or docker for windows desktop . \
2.) Helm \
3.) kubectl

versions installed on my machine . \
kubernetes v1.28+ \
helm v3.14+ \
docker image > achandre/mediawiki (MediaWiki 1.43.6 LTS)

# How to run 

The chart deploys both the MediaWiki application and a MariaDB database in a single install.

To deploy:

```
helm install mediawiki ./mediawiki-chart
```

Configure database credentials in `mediawiki-chart/values.yaml` under the `mariadb` section before installing:

```yaml
mariadb:
  auth:
    rootPassword: your-root-password
    password: your-user-password
    database: mediawikidb
    user: wikiuser
```

The application will be served on the external IP provided by the load balancer on port 8080.
The database host will be available at `<release>-mediawiki-mariadb:3306` within the cluster.

To disable the built-in MariaDB (e.g. to use an external database), set `mariadb.enabled: false`.

## LocalSettings.php

After initial setup, MediaWiki generates a `LocalSettings.php` file. You can provide it as a ConfigMap by adding it to your values:

```yaml
localSettings:
  enabled: true
  content: |
    <?php
    # Your LocalSettings.php content here
```

Alternatively, pass it at install time:

```
helm install mediawiki ./mediawiki-chart --set-file localSettings.content=LocalSettings.php --set localSettings.enabled=true
```
