# Yum
Simple and database-less cookbook for your best recipes.

![Yum logo](https://github.com/asondej/Yum/blob/main/yum/app/templates/default/images/yum-logo.svg)
[DEMO](http://yum.asondej.com/)

## What do I need?

PHP 8, Apache and Composer.

## How to use it?

### Upload

#### 1. Upload files from 'yum' folder to your public_html directory. Connect to console via ssh and go to folder 'app', then run ```composer install```

or

#### 2. Open folder app in your local console, run ```composer install``` and then upload 'yum' folder with newly generated "vendor" folder.

### Settings 

Open file index.php and set "atodelete" option to ```false```

### Create and edit new recipe

You can create new recipe by using fornm on a website, or by creating new title-recipe.md file in 'recipes' folder. You can edit the files to change recipe content.



