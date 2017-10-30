<?php

namespace Codemax\VoxStream;


interface VoxInterface
{
    public function setHost($host);
    public function setChaveAPI($chave);
    public function getHost();
    public function getChaveAPI();
}