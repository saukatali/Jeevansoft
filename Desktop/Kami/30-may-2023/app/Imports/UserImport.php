<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\User;

class UserImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        return new User([
            'name' => $row[0],
            'email' => $row[1],
            'password' => bcrypt($row[2]),
        ]);
    }
}
