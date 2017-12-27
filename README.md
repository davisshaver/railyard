# Railyard

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

### Lando workflow

### Launching a new site

1. Setup access tokens in your local environment.
  ```
  export GITHUB_TOKEN=[REDACTED]
  export CIRCLE_TOKEN=[REDACTED]
  ```

2. Authenticate Composer to Github.

  `composer config --global github-oauth.github.com $GITHUB_TOKEN`

2. Create a new site.
  ```
  terminus build:project:create davisshaver/railyard popularhistory --team="Philly Publishing"
  ```

  Note: You will be asked to authenticate with the Pantheon git repository using your Pantheon dashboard password.

  Warning: This step will create a new Pantheon sandbox site and public Github repository.

3. Make the Github repository private.

