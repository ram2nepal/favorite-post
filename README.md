# Favorites for Wordpress

## Overview

Favorites is a WordPress plugin developed to add posts as favorites. It provides an easy-to-use API for adding favorite button functionality to any post type.

### Installation - WP Directory Download
1. Upload the favorites plugin directory to the wp-content/plugins/ directory
2. Activate the plugin through the Plugins menu in WordPress

### Usage
When you activate the plugin, you will see a button on single posts page to add as a favorite. You need to be logged in to add as favorite.

### Shortcode
Place the shortcode ['favorite_post_display'] to display the favorites post of a current user.

### Widget
You can use Favorite posts widget to in your site via wp-content/appearance/widgets/favorite-post-list-widgets.

### API
In order to display the user favorite lists -{site_url}/wp-json/favorite-post/v2/author/<id>
In order to update the user favorite lists - {site_url}/wp-json/favorite-post/v2/author/?author_id=&old_post_id=&new_id=


