# SkiloisirsDiffusion

<div align="center">
    
[![Build Status](https://travis-ci.org/tyteck/skiloisirsdiffusion.svg?branch=main)](https://travis-ci.org/tyteck/skiloisirsdiffusion)
[![HitCount](http://hits.dwyl.io/tyteck/skiloisirsdiffusion.svg)](http://hits.dwyl.io/tyteck/skiloisirsdiffusion)

</div>

## Description
The goal of this lib is to help developers to interact with SkiLoisirsDiffusion SOAP API.
This api require lot of data and I hope this help will help.

## Installation/Requirements
```
composer require tyteck/skiloisirsdiffusion
```

## Usage
First of all you should fill a .env (or config file) with the value as showed in `.env-sample`.

Here are some examples.

### ETAT_SITE
```
SkiLoisirsDiffusion::create($this->sldDomainUrl, $this->partenaireId)->ETAT_SITE()
```
Will return true if Skiloisirs Diffusion servers are online.


## Todo
Actually I'm trying to make dataset creation as easy as possible. 
I'm not used to consume SOAP APIs so it's a little fight with myself.
Any help appreciated.