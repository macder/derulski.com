<?php

$filter = new Twig_SimpleFilter('resize', function ($string, $w = null, $h = null) {
  return $string;
});
