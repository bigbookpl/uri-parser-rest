# Uri-Parser Rest Server

## How to

### Run server (server will work 5 minutes)
```
composer start
```

### Use server

Send request using desktop client ie. Postman
```
[POST] http://127.0.0.1:8080/parse

{
    "uri": "http://mikaelblomkvist.se/"
}
```

Send request using Curl
```bash
curl -X POST -H "Content-Type:application/json" -d '{"uri": "http://mikaelblomkvist.se/"}' http://127.0.0.1:8080/parse
```