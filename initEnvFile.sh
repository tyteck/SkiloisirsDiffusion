#!/bin/bash

cp .env-sample .env
for varName in SLD_PARTENAIRE_ID SLD_DOMAIN_URL CLEF_SECRETE CE_SOCIETE CE_NOM CE_PRENOM CE_EMAIL CE_CODEPOSTAL CE_VILLE; do
    echo "${varName} -> ${!varName}"
    sed -i 's/\('"${varName}"'*= *\).*/\1'"${!varName}"'/' .env
done
cat .env
