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

WordPress will accept requests at any hostname. If you would like to change the hostname, simply modify the proxy edge reference in `.lando.yml`. You should also change the Lando name to match your app name (usually same as repo name). If you have multiple Lando apps running, you may also need to change the external access port for the database.

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
lando wp transient delete --all
```

3. Delete pending comments and pingbacks.

In lieu of a WP CLI command, Sequel Pro can be used to delete pingbacks/trackbacks manually.

4. Profile largest tables.

```
wp db size --tables
```

For your prefix (usually `wp_`), we need to keep the following tables:

- `wp_commentmeta`
- `wp_comments`
- `wp_links`
- `wp_options`
- `wp_postmeta`
- `wp_posts`
- `wp_term_relationships`
- `wp_term_taxonomy`
- `wp_termmeta`
- `wp_terms`
- `wp_usermeta`
- `wp_users`

Keep an eye out for extra tables, you may be able to delete them.

5. Transferring files to S3.

Before you begin, you'll need the following:

- S3 Bucket
- IAM user key/secret w/ S3 full permissions on bucket
- [AWS CLI](https://github.com/aws/aws-cli) on server

On third-party servers we want to be extremely cautious of leaving the environment undisturbed.

You can short-circuit the profile configured to AWS by exporting your own key/secret to the environment:

```
export AWS_ACCESS_KEY_ID="REDACTED"
export AWS_SECRET_ACCESS_KEY="REDACTED"
export AWS_DEFAULT_REGION="us-east-1"
```

Now if you run `aws s3 ls` you should see the S3 bucket listed.

Assuming a standard WordPress installation, running this command from the app root will begin a sync process to your bucket:

```
aws s3 sync ./wp-content/uploads/ s3://onwardstate-uploads/uploads/
```

Now we can unset our environment variables. It's like we were never even here! 

```
unset AWS_ACCESS_KEY_ID
unset AWS_SECRET_ACCESS_KEY
unset AWS_DEFAULT_REGION
```

If you have setup and activated S3 Uploads, image files should load at this point. You may also want to sync all or part of S3 bucket to your Pantheon server for redundancy. 

For local development, S3 Uploads [suggests the following](https://github.com/humanmade/S3-Uploads#offline-development):

> While it's possible to use S3 Uploads for local development (this is actually a nice way to not have to sync all uploads from production to development), if you want to develop offline you have a couple of options.

> 1. Just disable the S3 Uploads plugin in your development environment.
> 2. Define the S3_UPLOADS_USE_LOCAL constant with the plugin active.

> Option 2 will allow you to run the S3 Uploads plugin for production parity purposes, it will essentially mock Amazon S3 with a local stream wrapper and actually store the uploads in your WP Upload Dir /s3/.

At this point, you may still have an unnecessarily large uploads folder. Here are some strategies for reducing the size.

Using [Node S3 Utils](https://www.npmjs.com/package/node-s3-utils), we can list the uploads that have the mark of being auto-generated by WordPress. Specifically containing the last bit of `####x####.jpg`. 

```
s3utils files delete -c ./.s3-credentials.json -p uploads/ -r 'uploads\/[0-9]{4}\/[0-9]{1,2}\/(.*-[0-9]{1,4}x[0-9]{1,4}.(png|gif|jpg))'
```

However this function would need to be run repeatedly for the images to be cleared.

You may also want to double check that all posts have a featured image. The featured image features was introduced in version 2.9 (December 18th, 2009).  Install [Run Command's Assign Featured Image](https://github.com/runcommand/assign-featured-images) package and then preview & run as follows:

```
lando wp --url=onwardstate.lndo.site assign-featured-images --dry-run --only-missing
lando wp --url=onwardstate.lndo.site assign-featured-images --only-missing
```

6. Removing subscribers.

We can use WP CLI to lookup subscribers and delete subscribers without posts.

```
wp user delete $(wp db query "SELECT ID FROM os08_users WHERE ID NOT IN ( SELECT DISTINCT post_author FROM os08_posts ) AND ID NOT IN (4)" --url=onwardstate.lndo.site | tail -n +2 ) --url=onwardstate.lndo.site --reassign=1
```

The `4` here is the admin ID, which can be obtained with somthing like `wp user list --role=administrator --field=ID`. Comma separate multiple administrator ID's to ignore.

### Theme

Terminal is the required theme for Philly Publishing publishers.