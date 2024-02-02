# Deployment

## Updating demo site

When new production version is ready, it can be deployed to the demo site. Merge changes to `production` branch and push to github. Github action compiles js and merges build files and ``production`` branch to `deploy` branch.

Login to the server and run script `deploy.sh` to update the demo site.

**If you made changes to roles or permissions, you need to run**

```bash

php artisan update:roles

```
 ## Deploying to production

When the demo site is tested and ready, it can be deployed to the production site. Follow the same steps as for the demo site.