# scootr SPID

[scootr](https://github.com/alex-sandri/scootr)'s service to handle [SPID](https://www.spid.gov.it/) authentication.

## Set up

### Production

1. Create a resource group\
`az group create --name scootr --location "West Europe"`

2. Create a Container Registry\
`az acr create --name scootrregistry --resource-group scootr --sku Basic --admin-enabled true`

3. Retrieve credentials\
`az acr credential show --resource-group scootr --name scootrregistry`

4. Sign in to the registry\
`docker login scootrregistry.azurecr.io --username scootrregistry`

5. Create an App Service plan\
`az appservice plan create --name scootr-asp --resource-group scootr --sku B1 --is-linux`
