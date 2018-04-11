<?php

$filter = new Twig_SimpleFilter('wpautop', function ($string, $br = true) {
  return $string;
});
