# scootr SPID

[scootr](https://github.com/alex-sandri/scootr)'s service to handle [SPID](https://www.spid.gov.it/) authentication.

## Set up

### Production

1. Create a resource group
```
az group create --name scootr --location "West Europe"
```

2. Create a Container Registry
```
az acr create --name scootrregistry --resource-group scootr --sku Basic --admin-enabled true
```

3. Retrieve credentials
```
az acr credential show --resource-group scootr --name scootrregistry
```

4. Sign in to the registry
```
docker login scootrregistry.azurecr.io --username scootrregistry
```

5. Build the local image
```
docker build . -t sp:latest
```

6. Tag the local image for the registry
```
docker tag sp scootrregistry.azurecr.io/sp:latest
```

7. Push *Service Provider* image to the registry
```
docker push scootrregistry.azurecr.io/sp:latest
```

8. Create an App Service plan
```
az appservice plan create --name scootr-asp --resource-group scootr --sku B1 --is-linux
```

9. Create Web App
```
az webapp create --resource-group scootr --plan scootr-asp --name scootr --deployment-container-image-name scootrregistry.azurecr.io/sp:latest
```

10. Add custom domain
```
az webapp config hostname add --hostname spid.scootr.it --resource-group scootr --webapp-name scootr
```

11. Create a managed certificate for the custom domain
```
az webapp config ssl create --resource-group scootr --name scootr --hostname spid.scootr.it
```

12. Bind the SSL certificate to the web app
```
az webapp config ssl bind --certificate-thumbprint {certificate-thumbprint} --name scootr --resource-group scootr --ssl-type SNI
```

13. Add environment settings to the web app
```
az webapp config appsettings set -g scootr -n scootr --settings ENV=
az webapp config appsettings set -g scootr -n scootr --settings SP_ENTITYID=
az webapp config appsettings set -g scootr -n scootr --settings DATABASE_CONNECTION_STRING=
az webapp config appsettings set -g scootr -n scootr --settings STRIPE_SECRET_API_KEY=
az webapp config appsettings set -g scootr -n scootr --settings CLIENT_HOST=
```
