<?php

namespace SkiLoisirsDiffusion\Datasets;

class CeDatasetTable
{
    public static function create()
    {
        return DatasetTable::create('ce')
            ->addDatasetFields(
                [
                    DatasetField::create('ce_id', 'string', sldconfig('sld_partenaire_id')),
                    DatasetField::create('ce_societe', 'string', sldconfig('ce_societe')),
                    DatasetField::create('ce_civilite', 'string', null, 0, false),
                    DatasetField::create('ce_nom', 'string', sldconfig('ce_nom')),
                    DatasetField::create('ce_prenom', 'string', sldconfig('ce_prenom')),
                    DatasetField::create('ce_telephone', 'string', null, 0, false),
                    DatasetField::create('ce_portable', 'string', null, 0, false),
                    DatasetField::create('ce_fax', 'string', null, 0, false),
                    DatasetField::create('ce_email', 'string', sldconfig('ce_email')),
                    DatasetField::create('ce_adresse_nom', 'string', null, 0, false),
                    DatasetField::create('ce_adresse1', 'string', null, 0, false),
                    DatasetField::create('ce_adresse2', 'string', null, 0, false),
                    DatasetField::create('ce_codepostal', 'string', sldconfig('ce_codepostal')),
                    DatasetField::create('ce_ville', 'string', sldconfig('ce_ville')),
                    DatasetField::create('ce_pays', 'string', null, 0, false),
                ]
            );
    }
}
