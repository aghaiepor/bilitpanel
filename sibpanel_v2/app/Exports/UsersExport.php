<?php

namespace App\Exports;

use App\Api\Api;
use App\Http\Controllers\ReportController;
use App\User;
//use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    var $information ;
    public function __construct($information)
    {
        $this->information = $information;
    }

    public function collection()
    {
        return new Collection($this->information);
    }

}
