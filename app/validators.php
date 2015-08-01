<?php

Validator::extend('alpha_spaces_dash', function($attribute, $value, $parameters)
{
    return preg_match('/^[\pL\s\-]+$/u', $value);
});