# Siret : Validate

<div align="center">
    
[![Build Status](https://travis-ci.org/tyteck/siret.svg?branch=master)](https://travis-ci.org/tyteck/siret)
[![HitCount](http://hits.dwyl.io/tyteck/siret.svg)](http://hits.dwyl.io/tyteck/siret)

</div>

## Description
Small package to validate siret number.

## Installation
If you use composer you can simply run 
```
composer require tyteck/siret
```

## Usage
```
use Tyteck\Siret\Siret;
...
if (Siret::isValid($siretNumber)){
    // your code
}
```

## Todo
* some siret are specifics and do not comply with standard validation
    * la poste
    * siret from monaco
* generate fake siret number for factories
* truly verify if siret is assigned to a company (if possible)
