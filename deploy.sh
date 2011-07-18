#!/bin/bash

echo "Deploying Site\n";
ln -s  /var/www/rebuzzsites_trunk/index.php index.php
ln -s  /var/www/rebuzzsites_trunk/info.php info.php
ln -s  /var/www/rebuzzsites_trunk/license.txt license.txt
ln -s  /var/www/rebuzzsites_trunk/README README
ln -s  /var/www/rebuzzsites_trunk/wp-activate.php wp-activate.php

mkdir wp-admin

ln -s   /var/www/rebuzzsites_trunk/wp-admin/admin-ajax.php wp-admin/admin-ajax.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/admin-footer.php wp-admin/admin-footer.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/admin-functions.php wp-admin/admin-functions.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/admin-header.php wp-admin/admin-header.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/admin.php wp-admin/admin.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/admin-post.php wp-admin/admin-post.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/async-upload.php wp-admin/async-upload.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/comment.php wp-admin/comment.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/credits.php wp-admin/credits.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/css wp-admin/css
ln -s   /var/www/rebuzzsites_trunk/wp-admin/custom-background.php wp-admin/custom-background.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/custom-header.php wp-admin/custom-header.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/edit-comments.php wp-admin/edit-comments.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/edit-form-advanced.php wp-admin/edit-form-advanced.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/edit-form-comment.php wp-admin/edit-form-comment.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/edit-link-form.php wp-admin/edit-link-form.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/edit.php wp-admin/edit.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/edit-tag-form.php wp-admin/edit-tag-form.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/edit-tags.php wp-admin/edit-tags.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/export.php wp-admin/export.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/freedoms.php wp-admin/freedoms.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/gears-manifest.php wp-admin/gears-manifest.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/images wp-admin/images
ln -s   /var/www/rebuzzsites_trunk/wp-admin/import.php wp-admin/import.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/includes wp-admin/includes
ln -s   /var/www/rebuzzsites_trunk/wp-admin/index-extra.php wp-admin/index-extra.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/index.php wp-admin/index.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/install-helper.php wp-admin/install-helper.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/install.php wp-admin/install.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/js wp-admin/js
ln -s   /var/www/rebuzzsites_trunk/wp-admin/link-add.php wp-admin/link-add.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/link-manager.php wp-admin/link-manager.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/link-parse-opml.php wp-admin/link-parse-opml.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/link.php wp-admin/link.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/load-scripts.php wp-admin/load-scripts.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/load-styles.php wp-admin/load-styles.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/maint wp-admin/maint
ln -s   /var/www/rebuzzsites_trunk/wp-admin/media-new.php wp-admin/media-new.php 
ln -s   /var/www/rebuzzsites_trunk/wp-admin/media.php wp-admin/media.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/media-upload.php wp-admin/media-upload.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/menu-header.php wp-admin/menu-header.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/menu.php wp-admin/menu.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/moderation.php wp-admin/moderation.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/ms-admin.php wp-admin/ms-admin.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/ms-delete-site.php wp-admin/ms-delete-site.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/ms-edit.php wp-admin/ms-edit.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/ms-options.php wp-admin/ms-options.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/ms-sites.php wp-admin/ms-sites.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/ms-themes.php wp-admin/ms-themes.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/ms-upgrade-network.php wp-admin/ms-upgrade-network.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/ms-users.php wp-admin/ms-users.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/my-sites.php wp-admin/my-sites.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/nav-menus.php wp-admin/nav-menus.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/network wp-admin/network
ln -s   /var/www/rebuzzsites_trunk/wp-admin/network.php wp-admin/network.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/options-discussion.php wp-admin/options-discussion.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/options-general.php wp-admin/options-general.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/options-head.php wp-admin/options-head.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/options-media.php wp-admin/options-media.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/options-permalink.php wp-admin/options-permalink.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/options.php wp-admin/options.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/options-privacy.php wp-admin/options-privacy.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/options-reading.php wp-admin/options-reading.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/options-writing.php wp-admin/options-writing.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/plugin-editor.php wp-admin/plugin-editor.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/plugin-install.php wp-admin/plugin-install.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/plugins.php wp-admin/plugins.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/post-new.php wp-admin/post-new.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/post.php wp-admin/post.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/press-this.php wp-admin/press-this.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/profile.php wp-admin/profile.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/revision.php wp-admin/revision.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/setup-config.php wp-admin/setup-config.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/theme-editor.php wp-admin/theme-editor.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/theme-install.php wp-admin/theme-install.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/themes.php wp-admin/themes.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/tools.php wp-admin/tools.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/update-core.php wp-admin/update-core.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/update.php wp-admin/update.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/upgrade-functions.php wp-admin/upgrade-functions.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/upgrade.php wp-admin/upgrade.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/upload.php wp-admin/upload.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/user wp-admin/user
ln -s   /var/www/rebuzzsites_trunk/wp-admin/user-edit.php wp-admin/user-edit.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/user-new.php wp-admin/user-new.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/users.php wp-admin/users.php
ln -s   /var/www/rebuzzsites_trunk/wp-admin/widgets.php wp-admin/widgets.php

ln -s  /var/www/rebuzzsites_trunk/wp-app.php wp-app.php
ln -s  /var/www/rebuzzsites_trunk/wp-atom.php wp-atom.php
ln -s  /var/www/rebuzzsites_trunk/wp-blog-header.php wp-blog-header.php
ln -s  /var/www/rebuzzsites_trunk/wp-comments-post.php wp-comments-post.php
ln -s  /var/www/rebuzzsites_trunk/wp-commentsrss2.php wp-commentsrss2.php

mkdir wp-content
mkdir wp-content/uploads


ln -s  /var/www/rebuzzsites_trunk/wp-content/plugins ./wp-content/plugins
ln -s  /var/www/rebuzzsites_trunk/wp-content/themes ./wp-content/themes

ln -s  /var/www/rebuzzsites_trunk/wp-cron.php wp-cron.php
ln -s  /var/www/rebuzzsites_trunk/wp-feed.php wp-feed.php
ln -s  /var/www/rebuzzsites_trunk/wp-includes wp-includes
ln -s  /var/www/rebuzzsites_trunk/wp-links-opml.php wp-links-opml.php
ln -s  /var/www/rebuzzsites_trunk/wp-load.php wp-load.php
ln -s  /var/www/rebuzzsites_trunk/wp-login.php wp-login.php
ln -s  /var/www/rebuzzsites_trunk/wp-mail.php wp-mail.php
ln -s  /var/www/rebuzzsites_trunk/wp-pass.php wp-pass.php
ln -s  /var/www/rebuzzsites_trunk/wp-rdf.php wp-rdf.php
ln -s  /var/www/rebuzzsites_trunk/wp-register.php wp-register.php
ln -s  /var/www/rebuzzsites_trunk/wp-rss2.php wp-rss2.php
ln -s  /var/www/rebuzzsites_trunk/wp-rss.php wp-rss.php
ln -s  /var/www/rebuzzsites_trunk/wp-settings.php wp-settings.php
ln -s  /var/www/rebuzzsites_trunk/wp-signup.php wp-signup.php
ln -s  /var/www/rebuzzsites_trunk/wp-trackback.php wp-trackback.php
ln -s  /var/www/rebuzzsites_trunk/xmlrpc.php xmlrpc.php