<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

/**
 * Laravel 11/12 secara default TIDAK menyertakan trait AuthorizesRequests
 * di base Controller. Trait ini WAJIB ada supaya $this->authorize()
 * di PostController berfungsi.
 */
abstract class Controller
{
    use AuthorizesRequests, ValidatesRequests;
}
