#!/bin/bash

CURRDIR="$( cd "$( dirname "$0" )" && pwd )"

echo "Deploying Site\n";
ln -s  $CURRDIR/index.php index.php
ln -s  $CURRDIR/info.php info.php
ln -s  $CURRDIR/license.txt license.txt
ln -s  $CURRDIR/README README
ln -s  $CURRDIR/wp-activate.php wp-activate.php

mkdir wp-admin

for i in $CURRDIR/wp-admin/*
do
ln -s $i ${i#$CURRDIR/}
done

ln -s  $CURRDIR/wp-app.php wp-app.php
ln -s  $CURRDIR/wp-atom.php wp-atom.php
ln -s  $CURRDIR/wp-blog-header.php wp-blog-header.php
ln -s  $CURRDIR/wp-comments-post.php wp-comments-post.php
ln -s  $CURRDIR/wp-commentsrss2.php wp-commentsrss2.php

mkdir wp-content
mkdir wp-content/uploads


ln -s  $CURRDIR/wp-content/plugins ./wp-content/plugins
ln -s  $CURRDIR/wp-content/themes ./wp-content/themes

ln -s  $CURRDIR/wp-cron.php wp-cron.php
ln -s  $CURRDIR/wp-feed.php wp-feed.php
ln -s  $CURRDIR/wp-includes wp-includes
ln -s  $CURRDIR/wp-links-opml.php wp-links-opml.php
ln -s  $CURRDIR/wp-load.php wp-load.php
ln -s  $CURRDIR/wp-login.php wp-login.php
ln -s  $CURRDIR/wp-mail.php wp-mail.php
ln -s  $CURRDIR/wp-pass.php wp-pass.php
ln -s  $CURRDIR/wp-rdf.php wp-rdf.php
ln -s  $CURRDIR/wp-register.php wp-register.php
ln -s  $CURRDIR/wp-rss2.php wp-rss2.php
ln -s  $CURRDIR/wp-rss.php wp-rss.php
ln -s  $CURRDIR/wp-settings.php wp-settings.php
ln -s  $CURRDIR/wp-signup.php wp-signup.php
ln -s  $CURRDIR/wp-trackback.php wp-trackback.php
ln -s  $CURRDIR/xmlrpc.php xmlrpc.php

touch rb-config.php
touch wp-config.php