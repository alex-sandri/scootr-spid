# scootr SPID

[scootr](https://github.com/alex-sandri/scootr)'s service to handle [SPID](https://www.spid.gov.it/) authentication.

## Set up

### Production

Create a resource group\
`az group create --name scootr --location "West Europe"`

Create a Container Registry\
`az acr create --name scootrregistry --resource-group scootr --sku Basic --admin-enabled true`

Retrieve credentials\
`az acr credential show --resource-group scootr --name scootrregistry`

Sign in to the registry\
`docker login scootrregistry.azurecr.io --username scootrregistry`

Create an App Service plan\
`az appservice plan create --name scootr-asp --resource-group scootr --sku B1 --is-linux`
