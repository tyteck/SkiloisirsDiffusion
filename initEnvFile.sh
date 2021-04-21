#!/bin/bash

cp .env-sample .env
for varName in SLD_PARTENAIRE_ID SLD_DOMAIN_URL CLEF_SECRETE CE_SOCIETE CE_NOM CE_PRENOM CE_EMAIL CE_CODEPOSTAL CE_VILLE; do
    sed -i 's#'="${varName}"'#'="${!varName}"'#' .env
done
cat .env
