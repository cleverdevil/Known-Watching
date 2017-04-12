Watching for Known
==================

Adds support for publishing what you're watching (TV and movies) to the [Known
CMS](http://withknown.com). To install, simply clone this repository to your
`IdnoPlugins` subdirectory of your Known installation, using the directory name
`Watching`, and enable the plugin.

![Example post](http://share.cleverdevil.io/WVuHQe5hvz.png)

This plugin also includes experimental support for creating posts via [Plex
Webhook](https://support.plex.tv/hc/en-us/articles/115002267687-Webhooks).
The plugin creates an endpoint at `/watching/webhook/` that will response to
`media.play` webhooks if configured in [Plex](http://plex.tv). Currently, the
endpoint code hardcodes some things specific to my site and Plex account, so
you'll need to make changes if you want to use this functionality.

Eveventually, I'll make this configurable. Pull requests welcome :)
