<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
/**
 * Kelas dasar untuk semua controller di Laravel.
 * Gunakan trait Laravel bawaan:
 * - AuthorizesRequests: otorisasi aksi user
 * - DispatchesJobs: memanggil queue/job
 * - ValidatesRequests: validasi input request
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
