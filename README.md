# Railyard
This is the starter kit for new Philly Publishing Company sites. It lays out the tracks for local development and new site creation. Proprietary code and secrets can be included on a per site basis using Composer or direct commits.

## Local development

### Prerequisites
These tools should be installed on your local system before you begin.

- Composer
- PHP
- Terminus
   Requires:
   - Build Tools Plugin
   - Authentication w/ `terminus auth:login`
   - Composer plugin
- Lando

Recommended:

- AWS CLI
- GoAccess
  After you have installed GoAccess, add the following lines to your GoAccess configuration:

  ```
  # Log output for Railyard
  time-format %H:%M:%S
  date-format %d/%b/%Y
  log-format %h - %^ [%d:%t %^]  "%r" %s %b "%R" "%u" %T "%^"%
  ```

### Lando workflow

New sites are ready to go with `lando start` from the project root. See `.env.sample` for keys supported in `.env`.

You may want to run `lando db-import ./private/local/railyard.sql.gz` next. This populates the database to simulate a typical Philly Publishing site.

WordPress will accept requests at any hostname. If you would like to change the hostname, simply modify the proxy edge reference in `.lando.yml`.

**Note:** Offline development with Lando requires configuration via [DNSMasq](https://docs.devwithlando.io/tutorials/offline-dev.html).

### Launching a new site

  1. Setup access tokens in your local environment.

  ```
  export GITHUB_TOKEN=[REDACTED]
  export CIRCLE_TOKEN=[REDACTED]
  ```

  **Note:** Later you may want to add the `SITE_GUID` and `PACKAGIST_TOKEN`/`PACKAGIST_USER` to your environment. We'll use these to collect logs and download private repos, respectively.

  2. Create a new site.
  
  ```
  terminus build:project:create davisshaver/railyard popularhistory --team="Philly Publishing"
  ```

  **Note:** You will be asked to authenticate with the Pantheon git repository using your Pantheon dashboard password. Prevent this step by authenticating git with an SSH key.

  **Warning:** This step will create a new Pantheon sandbox site and public Github repository.
 
  3. Make the Github repository private.

  4. Configure optional secrets in the CircleCI environment.

  - Packagist._com_ Token
  - Slack Webhook URL

  **Warning:** You should *disable* the advanced setting `Pass secrets to builds from forked pull requests`.

### Merging upstream updates
The git tree of this repository is based on the upstream Pantheon project, but child repositories begin with fresh histories. We recommend this strategy of merging upstream updates into the site repository:

```
git pull railyard master --allow-unrelated-histories
```

## Logs

## Existing site import

Here are some tips for cleaning up existing sites.

1. Install the Revisions command for WP CLI and then delete. [See docs for more options.](https://github.com/trepmal/wp-revisions-cli).

```
  lando wp package install trepmal/wp-revisions-cli
  lando wp revisions clean --hard
  lando wp db optimize
```

2. Delete transients.

```
wp transient delete --all
```

3. Delete pending comments and pingbacks.

```

```

4. Profile largest tables.

```
wp db size --tables
```

For your prefix (usually `wp_`), we need to keep the following tables:

![wp4 4 2-erd](https://user-images.githubusercontent.com/1636964/34419958-c0170cb8-ebd4-11e7-950b-b4721798229c.png)

Keep an eye out for extra tables and/or columns.

