# wpentitytool
PHP based console tool to generate code for custom Wordpress Post-types and Meta fields for them (WIP)
Have to write you own templates though.

License: MIT

Usage: create a plugin (many tutorials online ) for example with the wp-cli tool
clone or extract this into the plugin directory 

into the plugin directory:

`git clone https://github.com/84GHz/wpentitytool.git`

to generate code for a post type:

`php wpentitytool/console`

and then follow the instructions in the console
(note the machine name that you typed in, that is the custom post type's slug)

to generate meta fields for the custom post type:

`php wpentitytool/console fields`

(enter the custom post machine name when asked)
if you press enter when asked for the name of the next field, the code is written / overwritten

