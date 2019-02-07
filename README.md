## Marvel - Drupal 8 module
This module allows your site to connect to Marvel Comics API so you can fetch and display data about your favorite characters.

### Prerequisite:
- Create an Marvel developer account and get API keys from https://developer.marvel.com/

### Usage:
- Install module.
- Configure API keys at `/admin/config/marvel/settings`.
- Go to `/marvel` and find your favorite Marvel characters.
- Or create a content type and add a Marvel field to it. Then enable the Memory Game formatter.

### Demo site:
http://drupal-242006-744060.cloudwaysapps.com/

### TODO:
- ~~Rename SuperheroSearch to MarvelSearch.~~
- ~~Rename Marvel formatter to MarvelMemoryGame.~~
- ~~Make new formatter called Default and display characters using the 'marvel_character' theme hook.~~
- ~~Create a Memory Game formatter to load the React game.~~
- Add more test coverage.
