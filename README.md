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
  - Slack URL

  **Warning:** You should *disable* the advanced setting `Pass secrets to builds from forked pull requests`.

### Merging upstream updates
The git tree of this repository is based on the upstream Pantheon project, but child repositories begin with fresh histories. We recommend this strategy of merging upstream updates into the site repository:

```
git pull railyard master --allow-unrelated-histories
```

## Logs