<?php

namespace App\Imports;

use App\Models\Person;
use Filament\Facades\Filament;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class PeopleImport implements ToCollection
{
    public function collection(Collection $collection)
    {
        $insert = collect();

        if ($collection->count() > 0) {
            // append tenant_id to each row
            $collection->each(function ($row) use (&$insert) {
                $insert->put('tenant_id', Filament::getTenant()->id);
                $insert->put('name', $row[0]);
                $insert->put('surname', $row[1]);
                $insert->put('document', $row[2]);
                $insert->put('birth_date', $row[3]);
                $insert->put('nationality', $row[4]);
                $insert->put('naturalness', $row[5]);
                $insert->put('profession', $row[6]);
                $insert->put('created_at', now());
                $insert->put('updated_at', now());
            });

            // insert all rows in the database
            Person::insert($insert->toArray());

            return true;
        }
    }
}
