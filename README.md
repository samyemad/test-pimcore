# Imported Pimcore | Setting up local environment

 Imported Pimcore application  
Developed by the samy Emad.

## Getting the files
```bash
git clone 
cd test-pimcore
```

## Dev Configuration

### Parameters
Create the `config/local/parameters.yaml` file. It should be configured with at least a unique secret.

```yaml
parameters:
    secret: unique-secret-key
```
### Doctrine
Create the `config/local/doctrine.yaml` file
```yaml
doctrine:
    dbal:
        connections:
            default:
                host: ddev-test-pimcore-db
                port: 3306
                dbname: db
                user: db
                password: db
                mapping_types:
                    enum: string
                    bit: boolean
                server_version: '10.7.3-MariaDB-1:10.7.3+maria~focal'
```

To make sure that the host's value is correct:

1. Run ``docker ps``
2. Verify if the db container name is equal to "ddev-test-pimcore-db". Otherwise, update the host's value in doctrine.yaml to make it similar to the db's container name.

## DDEV Setup

1. You *need* to have [`ddev`](https://ddev.readthedocs.io/en/stable/#installation) installed to run this stack.
2. Run `ddev start`.
3. Test Pimcore project is now available at the URLs described by the ddev CLI output.
4. Optional: If you need to import the DB you can download the fresh dump from the server and use `ddev import-db` command to import it

## Docker Setup

### Prerequisites

* You must have docker-compose installed.
* You must have Git installed.

### Start the containers
Run `docker-compose up -d`

