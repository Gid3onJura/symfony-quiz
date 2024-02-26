# Simple Symfony Web Application

## Little playground for symfony

### install

- Plugin "Live Server" for VSCode
- Plugin "PHP"
- Symfony CLI
- set config in settings.json

```json
"liveServer.settings.root": "/public",
"liveServer.settings.proxy": {
  "enable": true,
  "baseUri": "/",
  "proxyUri": "http://localhost:8000"
},
```

- start server

```cmd
symfony server:start
```

- open index in browser

```
https://localhost:8000/
```

### helpful links

- Database: https://symfony.com/doc/current/doctrine.html
- init git or add remote repo: https://www.entechlog.com/blog/general/how-to-add-existing-folder-to-git/
