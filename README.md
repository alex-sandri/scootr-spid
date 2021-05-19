# scootr SPID

[scootr](https://github.com/alex-sandri/scootr)'s service to handle [SPID](https://www.spid.gov.it/) authentication.

## Set up

### Requirements

- `Service Provider`:
  - [`Container Registry`](https://azure.microsoft.com/en-us/services/container-registry/): Set [`image`](docker-compose.prod.yml#L7) to `<your-container-registry>.azurecr.io/sp`
  - [`Storage Account`](https://azure.microsoft.com/en-us/services/storage/files/): Set [`storage_account_name`](docker-compose.prod.yml#L34) to `<your-storage-account>`
- `Identity Provider`:
  - [`Storage Account`](https://azure.microsoft.com/en-us/services/storage/files/): Set [`storage_account_name`](docker-compose.prod.yml#L39) to `<your-storage-account>`

### Deploy

`docker compose -f docker-compose.prod.yml up`
