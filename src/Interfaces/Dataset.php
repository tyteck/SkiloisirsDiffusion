<?php

namespace SkiLoisirsDiffusion\Interfaces;

use stdClass;

interface Dataset
{
    public function schema():string;

    public function body():string;

    public function dataset():stdClass;
}
