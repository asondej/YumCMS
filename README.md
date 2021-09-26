# Yum
Simple and database-less cookbook for your best recipes. __[DEMO](http://yum.asondej.com/)__
<br>
[![Yum logo](https://github.com/asondej/Yum/blob/main/yum/app/templates/default/images/yum-logo.svg)](http://yum.asondej.com/)


## What do I need?

PHP 8, Apache and Composer.

## How to use it?

### Upload

#### 1. composer via ssh
Upload files from 'yum' folder to your public_html directory. Connect to console via ssh and go to folder 'app', then run ```composer install```

or

#### 2. composer via local terminal
Open folder app in your local console, run ```composer install``` and then upload 'yum' folder with newly generated "vendor" folder.

### Settings 

Open file index.php and set "autodelete" option to ```false```

### Create and edit new recipe

You can create new recipe by using form on a website, or by creating new title-recipe.md file in 'recipes' folder. You can edit the files to change recipe content,
and use markdown.



