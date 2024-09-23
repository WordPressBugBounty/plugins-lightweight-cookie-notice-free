## Installation

Sass should be installed with this command

npm install -g sass

## How to compile the sass files

This command should be used when positioned in the main theme folder.

sass admin/assets/css/framework-menu/scss/init.scss:admin/assets/css/framework-menu/main.css --watch

This command should be used to produce a minified output:

sass admin/assets/css/framework-menu/scss/init.scss:admin/assets/css/framework-menu/main.css --watch --style compressed