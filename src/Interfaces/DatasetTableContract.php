<?php

namespace SkiLoisirsDiffusion\Interfaces;

interface DatasetTableContract
{
    public function schema():string;

    public function body():string;
}
